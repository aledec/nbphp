nbphp - Script
=====

Script used in order to execute netbackup commands and generate sql files for the database.
It used commands such as:
- bpplclients
- bperror
- bpimagelist
- bppllist
### Requirements
- Netbackup media Server running under Linux/HP-UX

### Installation
- Copy the script outdiario.sh into a directory of your netbackup server.
- Assign execution privileges to script
- Change variables related to your server in order to correct use:
```
	FTPHOST=''
	FTPPORT=''
	FTPUSER=''
	FTPPASS=''
	NBPATH="/usr/openv/netbackup/bin/admincmd"
```
- Test execution and correct generation
- Assign into crontab for required period, example
```
	20 3,7,11,15,19,23 * * * cd /root/scripts/nbphp-sql/; ./outdiario.sh
```

### Bugs
Need to update and improve code, it requires a lot of cpu due to compatibility statements for HPUX.
