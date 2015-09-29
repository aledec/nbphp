#!/usr/bin/ksh

#### Global variables
LASTEXECFILE=$0.lastexec
EXECDATE=$(date +%m/%d/%Y" "%H:%M:%S)
if [ -f $LASTEXECFILE ]; then # check if file for last execution exist for hours ago functions
  LASTEXECUTION=$(cat $LASTEXECFILE)
  echo $EXECDATE > $LASTEXECFILE
else
  echo $EXECDATE > $LASTEXECFILE
  echo "CANCEL, not last execution day found. Re execute"
  exit # cancel because there's not any other date fo check from, next execution will work
fi
DATE=$(date +%Y%m%d%H%M%S) # used to save files with date format

#### FTPHOST
HOST=''
PORT=''
USER=''
PASS=''
FTPLOG=$0.ftp.log

#######################################################################################################
# DO NOT CHANGE ANYTHING BELLOW THIS LINE AT LEAST YOU KNOWN WHAT YOU'RE DOING
#######################################################################################################
#### PATHS
NBPATH="/usr/openv/netbackup/bin/admincmd"
SRCDIR="src/"
OUTDIR="out/"
SQLDIR="sql/"

## CLIENTS
BINBPPLCLIENTS="$NBPATH/bpplclients -allunique"
OUTCLIENT=$SRCDIR/clients.txt.$DATE
SQLCLIENT=$SQLDIR/clients.sql.$DATE
SQLCLIENT_C="clients.sql.$DATE"
TMPCLIENT=$OUTDIR/clients.tmp

## ERRORS
BINERRORS="$NBPATH/bperror -U -backstat -d $LASTEXECUTION -e $EXECDATE"
OUTERRORS=$SRCDIR/errors.txt.$DATE
SQLERRORS=$SQLDIR/errors.sql.$DATE
SQLERRORS_C="errors.sql.$DATE"
TMPERRORS=$OUTDIR/errors.tmp

## IMAGES
BINIMAGES="$NBPATH/bpimagelist -L -d $LASTEXECUTION -e $EXECDATE"
OUTIMAGES2=$SRCDIR/images2.$DATE
OUTIMAGES=$SRCDIR/images.txt.$DATE
SQLIMAGES=$SQLDIR/images.sql.$DATE
SQLIMAGES_C="images.sql.$DATE"
TMPIMAGES=$OUTDIR/images.tmp
TMP2IMAGES=$OUTDIR/images.tmp2

## POLICIES
BINPOLICIES="$NBPATH/bppllist -allpolicies -L"
OUTPOLICIES=$SRCDIR/policies.txt.$DATE
SQLPOLICIES=$SQLDIR/policies.sql.$DATE
SQLPOLICIES_C="policies.sql.$DATE"
TMPPOLICIES=$OUTDIR/policies.tmp

####################################################################
# FUNCTIONS
####################################################################
limpiezaarchivos() {
rm -f $TMPCLIENT $TMPIMAGES $TMP2IMAGES $TMPPOLICIES $TMPERRORS
}

#funcion de carga de datos, unicamente carga el archivo especificado
copiarftp() {
FILE=$1

echo "Filename: $FILE Date $DATE" >> $FTPLOG
ftp -nvp $FTPHOST $FTPPORT>>$FTPLOG <<END_SCRIPT
quote USER $FTPUSER
quote PASS $FTPPASS
binary
put $FILE
quit
END_SCRIPT
}

# Funcion de carga de datos. Solo se usa en productivo.
cargadatoscatalogo() {
$BINBPPLCLIENTS | grep -ve '----' | grep -v "ardware" > $OUTCLIENT
$BINERRORS | grep -ve '----' | egrep -v "CLIENT|entity"> $OUTERRORS
$BINIMAGES | egrep 'Backup ID:|Client:|Policy:|Sched Label|Retention Level|Backup Time|Elapsed Time|Expiration Time|Kilobytes| Files| Copies|Backup Status' | egrep -v "Proxy Client|Previous Backup | Remote Expiration Time| Kilobytes" > $OUTIMAGES
$BINPOLICIES | egrep 'Policy Name:|template:|Policy Type:|Active:|Effective date:|Client/HW' > $OUTPOLICIES
}

############ Clients Function
clients() {
echo "use nbu;" > $TMPCLIENT
#clean file before insert syntax
echo "truncate table client;" >> $TMPCLIENT
echo "insert into client (hardware,os,client) values " >> $TMPCLIENT
#insert syntax
while read line; do
echo "(\"$(echo $line | awk '{print $1}')\",\"$(echo $line | awk '{print $2}')\",\"$(echo $line | awk '{print $3}')\")," >> $TMPCLIENT # need to be optimized
done < $OUTCLIENT
awk 'NR>n{print A[NR%n]} {A[NR%n]=$0}' n=1 $TMPCLIENT > $SQLCLIENT # extract all except last line
LASTLINE=$(awk '{gsub(/,$/,""); print}' $TMPCLIENT | tail -1) # extract last line
echo "$LASTLINE" >> $SQLCLIENT # append last line
echo ";" >> $SQLCLIENT #append end of query
}

############ Errors Function
errors() {
echo "use nbu;" > $TMPERRORS
#clean file before insert syntax
echo "insert ignore into errors (status,client,policy,type,date,result) values " >> $TMPERRORS

#insert syntax
while read line; do
value=$(echo $line | awk '{print $1}')
  case $value in # need to be optimized
    0)
                #Process date
                LINEDATE="$(echo $line | awk '{print $6" "$7}' | sed 's/\//:/g' | sed 's/:/ /g' | awk '{print $3"/"$1"/"$2" "$4":"$5":"$6}')"
                QUERY="(\"$(echo $line | awk '{print $1}')\", \"$(echo $line | awk '{print $2}')\", \"$(echo $line | awk '{print $3}')\", \"$(echo $line | awk '{print $4}')\", \"$(echo $LINEDATE)\", \"Success\"),"
                echo $QUERY >> $TMPERRORS # save into file
        ;;
        *)
            if echo $value | egrep -q '^[0-9]+$'; then # if line string contains result code or message
                        LINEDATE="$(echo $line | awk '{print $6" "$7}' | sed 's/\//:/g' | sed 's/:/ /g' | awk '{print $3"/"$1"/"$2" "$4":"$5":"$6}')"
                        RESULT="(\"$(echo $line | awk '{print $1}')\",\"$(echo $line | awk '{print $2}')\",\"$(echo $line | awk '{print $3}')\",\"$(echo $line | awk '{print $4}')\",\"$(echo $LINEDATE\"),"
                else
                        QUERY="$(echo $RESULT)\"$line\"),"
                        echo $QUERY >> $TMPERRORS # save into file
                        fi
  esac
done < $OUTERRORS
awk 'NR>n{print A[NR%n]} {A[NR%n]=$0}' n=1 $TMPERRORS > $SQLERRORS # extract all except last line
LASTLINE=$(awk '{gsub(/,$/,""); print}' $TMPERRORS | tail -1) # extract last line
echo "$LASTLINE" >> $SQLERRORS # append last line
echo ";" >> $SQLERRORS # append end of query
}

############ IMAGES FUNCTION
fimages() {
echo 'use nbu;' > $TMP2IMAGES
echo 'INSERT IGNORE INTO `nbu`.`images` (`client`, `client_timestamp`, `policy`, `sched_label`, `retention_level`, `backup_time`, `elapsed_time`, `expiration_time`, `kilobytes`, `number_of_files`, `number_of_copies`, `status`, `storage_lifecycle_policy`) VALUES' > $TMP2IMAGES 

#clean file before insert syntax
cat $OUTIMAGES | egrep -v "Proxy Client|Previous Backup | Remote Expiration Time| Kilobytes" > $TMPIMAGES
while read line; do
  case $line in # really need to be optimized NOW!
    Client*)
      INSERT="'$(echo $line | cut -d " " -f2-)'"
      LINEA="$INSERT"
    ;;
    Backup*ID*)
      INSERT=" ,'$(echo $line | cut -d " " -f3-)'"
      LINEA="$LINEA$INSERT"
    ;;
    Policy*)
      INSERT=" ,'$(echo $line | cut -d " " -f2-)'"
      LINEA="$LINEA$INSERT"
    ;;
    Sched*Label*)
      INSERT=" ,'$(echo $line | cut -d " " -f3-)'"
      LINEA="$LINEA$INSERT"
    ;;
    Retention*Level*)
      INSERT=" ,'$(echo $line | cut -d " " -f3-)'"
      LINEA="$LINEA$INSERT"
    ;;
    Backup*Time*)
      DATE="$(echo $line | cut -d " " -f3- | sed 's/\//:/g' | sed 's/:/ /g' | awk '{print $7" "$2" "$3" "$4" "$5" "$6}')" # UGLY
      MON_STR=$(echo $DATE | awk '{print $2}')
      if [[ "$MON_STR" = "Jan" ]]; then
        MON_NUM=01
      elif [[ "$MON_STR" = "Feb" ]]; then
        MON_NUM=02
      elif [[ "$MON_STR" = "Mar" ]]; then
        MON_NUM=03
      elif [[ "$MON_STR" = "Apr" ]]; then
        MON_NUM=04
      elif [[ "$MON_STR" = "May" ]]; then
        MON_NUM=05
      elif [[ "$MON_STR" = "Jun" ]]; then
        MON_NUM=06
      elif [[ "$MON_STR" = "Jul" ]]; then
        MON_NUM=07
      elif [[ "$MON_STR" = "Aug" ]]; then
        MON_NUM=08
      elif [[ "$MON_STR" = "Sep" ]]; then
        MON_NUM=09
      elif [[ "$MON_STR" = "Oct" ]]; then
        MON_NUM=10
      elif [[ "$MON_STR" = "Nov" ]]; then
        MON_NUM=11
      elif [[ "$MON_STR" = "Dec" ]]; then
        MON_NUM=12
      fi
      INSERT=" ,'$(echo $DATE | awk '{print $1}')-$(echo $MON_NUM)-$(echo $DATE | awk '{print $3" "$4":"$5":"$6}')'" # STILL UGLY
      LINEA="$LINEA$INSERT"
      ;;
    Elapsed*Time*)
      INSERT=" ,'$(echo $line | cut -d " " -f3- | awk '{print $1}')'"
      LINEA="$LINEA$INSERT"
    ;;
    Expiration*Time*)
      DATE="$(echo $line | cut -d " " -f3- | sed 's/\//:/g' | sed 's/:/ /g' | awk '{print $7" "$2" "$3" "$4" "$5" "$6}')"
      MON_STR=$(echo $DATE | awk '{print $2}')
      if [[ "$MON_STR" = "Jan" ]]; then
        MON_NUM=01
      elif [[ "$MON_STR" = "Feb" ]]; then
        MON_NUM=02
      elif [[ "$MON_STR" = "Mar" ]]; then
        MON_NUM=03
      elif [[ "$MON_STR" = "Apr" ]]; then
        MON_NUM=04
      elif [[ "$MON_STR" = "May" ]]; then
        MON_NUM=05
      elif [[ "$MON_STR" = "Jun" ]]; then
        MON_NUM=06
      elif [[ "$MON_STR" = "Jul" ]]; then
        MON_NUM=07
      elif [[ "$MON_STR" = "Aug" ]]; then
        MON_NUM=08
      elif [[ "$MON_STR" = "Sep" ]]; then
        MON_NUM=09
      elif [[ "$MON_STR" = "Oct" ]]; then
        MON_NUM=10
      elif [[ "$MON_STR" = "Nov" ]]; then
        MON_NUM=11
      elif [[ "$MON_STR" = "Dec" ]]; then
        MON_NUM=12
      fi
      INSERT=" ,'$(echo $DATE | awk '{print $1}')-$(echo $MON_NUM)-$(echo $DATE | awk '{print $3" "$4":"$5":"$6}')'"
      LINEA="$LINEA$INSERT"
      ;;
    Kilobytes*)
      INSERT=" ,'$(echo $line | cut -d " " -f2-)'"
      LINEA="$LINEA$INSERT"
    ;;
    Number*of*Files*)
      INSERT=" ,'$(echo $line | cut -d " " -f4-)'"
      LINEA="$LINEA$INSERT"
    ;;
    Number*of*Copies*)
      INSERT=" ,'$(echo $line | cut -d " " -f4-)'"
      LINEA="$LINEA$INSERT"
    ;;
    Backup*Status*)
      INSERT=" ,'$(echo $line | cut -d " " -f2- | awk '{print $2}')'"
      LINEA="$LINEA$INSERT"
    ;;
    Storage*Lifecycle*Policy*)
      INSERT=" ,'$(echo $line | cut -d " " -f4- )'"
      LINEA="$LINEA$INSERT"
    echo "($LINEA)," >> $TMP2IMAGES
    ;;
  esac
done < $TMPIMAGES
awk 'NR>n{print A[NR%n]} {A[NR%n]=$0}' n=1 $TMP2IMAGES > $SQLIMAGES # extract all except last line
LASTLINE=$(awk '{gsub(/,$/,""); print}' $TMP2IMAGES | tail -1) # extract last line
echo $LASTLINE >> $SQLIMAGES # append last line
echo ";" >> $SQLIMAGES # append end of query
}


policies() {
echo "use nbu;" > $TMPPOLICIES
echo "truncate table policies;" >> $TMPPOLICIES

while read line; do
  case $line in
    Policy*Name*)
        if [ -e $LINEA ]; then
          echo 'INSERT INTO `policies` (`name`, `template`, `type`, `active`, `active_since`, `client`) VALUES ' >> $TMPPOLICIES
        else
          echo "($LINEA ')," >> $TMPPOLICIES
        fi
      INSERT="'$(echo $line | cut -d " " -f3-)'"
      LINEA="$INSERT"
      ;;
    template*)
      INSERT=" ,'$(echo $line | cut -d " " -f2-)'"
      LINEA="$LINEA$INSERT"
      ;;
    Policy*Type*)
      INSERT=" ,'$(echo $line | cut -d " " -f3-)'"
      LINEA="$LINEA$INSERT"
      ;;
    Active*)
      INSERT=" ,'$(echo $line | cut -d " " -f2-)'"
      LINEA="$LINEA$INSERT"
      ;;
    Effective*date*)
      INSERT=" ,'$(echo $line | cut -d " " -f3- | tr -d "'" | sed 's/\//:/g' | sed 's/ /:/g' |awk -F: '{print $3"-"$1"-"$2" "$4":"$5":"$6}')', '"
      LINEA="$LINEA$INSERT"
      ;;
    Client*Compress*) # REMOVED
      #INSERT=",$(echo $line | cut -d " " -f3-),"
      #LINEA="$LINEA$INSERT"
      ;;
    Client*HW*)
      INSERT="$(echo $line | cut -d " " -f2- | awk '{print $1}') "
      LINEA="$LINEA$INSERT"
      ;;
    *)
      INSERT=""
      LINEA="$LINEA$INSERT"
      ;;
  esac
done < $OUTPOLICIES
awk 'NR>n{print A[NR%n]} {A[NR%n]=$0}' n=1 $TMPPOLICIES > $SQLPOLICIES # extract all except last line
LASTLINE=$(awk '{gsub(/,$/,""); print}' $TMPPOLICIES | tail -1) # extract last line
echo $LASTLINE >> $SQLPOLICIES # append last line
echo ";" >> $SQLPOLICIES # append end of query
}

####################################################################
# START
####################################################################
limpiezaarchivos; 
cargadatoscatalogo;
clients;
policies;
errors;
fimages;
 cd $SQLDIR
  copiarftp $SQLIMAGES_C; # COPY FILES
  copiarftp $SQLCLIENT_C; # COPY FILES
  copiarftp $SQLERRORS_C; # COPY FILES
  copiarftp $SQLPOLICIES_C; # COPY FILES
 cd -
