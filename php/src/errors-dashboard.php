<?php

class errors_StatusLike_ds { // % of return status like code - multiple params possible
	public $result_errorsstatus_like_0; 		/* Status 0*/
	public $result_errorsstatus_like_other;		/* Status NOT 0*/
	
	function errors_StatusLike_ds__data($params) { 
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'SELECT COUNT(*) as total FROM `errors` 
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() 
					AND status = 0';
			$result = $conn->query($sql);
			$this->result_errorsstatus_like_0 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors` 
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() 
					AND status != 0';
			$result = $conn->query($sql);
			$this->result_errorsstatus_like_other = $result->fetch_assoc();
		}
		else {
			$sql = 'SELECT COUNT(*) as total FROM `errors`
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					AND `policy` LIKE "%'.$params['policy'].'%"
					AND status = 0';
			$result = $conn->query($sql);
			$this->result_errorsstatus_like_0 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors`
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					AND `policy` LIKE "%'.$params['policy'].'%"		
					AND status != 0';
			$result = $conn->query($sql);
			$this->result_errorsstatus_like_other = $result->fetch_assoc();
		}
	}
	function errors_StatusLike_ds__graph($params) { 
		echo '
				widgetTitle : "Porcentaje de Exitosos '."$params[timeago]"." - $params[policy]".'",
				widgetId : "'."$params[name]".'",
				widgetType : "chart",
				widgetContent : {
				data : [
				{
				data : [[0, ' .$this->result_errorsstatus_like_0["total"]. ']],
				label: "Successful"
			},{
				data : [[0, ' .$this->result_errorsstatus_like_other["total"]. ']],
				label: "Not Successful",
						        pie: {
	            explode: 10
	        }
			
			}],
			options : {
	        HtmlText : false,
	        grid : {
	                verticalLines : false,
	                horizontalLines : false
	        },
	        xaxis : {
	                showLabels : false
	        },
	        yaxis : {
	                showLabels : false
	        },
	        pie : {
	                show : true,
	                explode : 6
	        },
			mouse: {
				track: true,
				trackDecimals: 0,
				trackFormatter: function (obj) {
				return obj.series.label + ": " + obj.y;
				}
			},
	        legend : {
	                position : "se",
	                backgroundColor : "#D2E8FF"
	        }
			}
			}';
	}
}

class errors_StatusLikeDefined_ds { // % of return status like code not 0 - multiple params possible
	public $result_errorsstatus_like_1; /* Status 1  (the requested operation was partially successful)*/
	public $result_errorsstatus_like_6; /* Status 6 (the backup failed to back up the requested files)*/
	public $result_errorsstatus_like_58; /* Status 58 (can't connect to client) */
	public $result_errorsstatus_like_other; /* OTHERS */

	function errors_StatusLikeDefined_ds__data($params) {
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'SELECT COUNT(*) as total FROM `errors` 
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() 
					AND status = 1';
				$result = $conn->query($sql);
				$this->errorsstatus_like_1 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors` 
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() 
					AND status = 6';
				$result = $conn->query($sql);
				$this->errorsstatus_like_6 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors` 
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() 
					AND status = 58';
				$result = $conn->query($sql);
				$this->errorsstatus_like_58 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors` 
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() 
					AND status != 0 AND status != 1 AND status != 6 AND status != 58';
				$result = $conn->query($sql);
				$this->errorsstatus_like_other = $result->fetch_assoc();
		}
		else {
			$sql = 'SELECT COUNT(*) as total FROM `errors`
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					AND `policy` LIKE "%'.$params['policy'].'%"	
					AND status = 1';
			$result = $conn->query($sql);
			$this->errorsstatus_like_1 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors`
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					AND `policy` LIKE "%'.$params['policy'].'%"	
					AND status = 6';
			$result = $conn->query($sql);
			$this->errorsstatus_like_6 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors`
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					AND `policy` LIKE "%'.$params['policy'].'%"	
					AND status = 58';
			$result = $conn->query($sql);
			$this->errorsstatus_like_58 = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `errors`
					WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					AND `policy` LIKE "%'.$params['policy'].'%"	
					AND status != 0 AND status != 1 AND status != 6 AND status != 58';
			$result = $conn->query($sql);
			$this->errorsstatus_like_other = $result->fetch_assoc();
		}
	}
	function errors_StatusLikeDefined_ds__graph($params) {
		echo '
				widgetTitle : "Porcentaje de Errores '."$params[timeago]"." - $params[policy]".'",
				widgetId : "'."$params[name]".'",
				widgetType : "chart",
				widgetContent : {
				data : [
				{
				data : [[0, ' .$this->errorsstatus_like_1["total"]. ']],
				label: "Partially Successful"
			},{
				data : [[0, ' .$this->errorsstatus_like_6["total"]. ']],
				label: "Failed to backup files"
			},{
				data : [[0, ' .$this->errorsstatus_like_58["total"]. ']],
				label: "Cant connect Client"
			},{
				data : [[0, ' .$this->errorsstatus_like_other["total"]. ']],
				label: "Otros"
			}],
			options : {
	        HtmlText : false,
	        grid : {
	                verticalLines : false,
	                horizontalLines : false
	        },
	        xaxis : {
	                showLabels : false
	        },
	        yaxis : {
	                showLabels : false
	        },
	        pie : {
	                show : true,
	                explode : 6
	        },
			mouse: {
				track: true,
				trackDecimals: 0,
				trackFormatter: function (obj) {
				return obj.series.label + ": " + obj.y;
				}
			},
	        legend : {
	                position : "se",
	                backgroundColor : "#D2E8FF"
	        }
			}
			}';
	
	}
}

class errors_PolicyLikeDefined_ds { // % of policy type - only timeago params possible
	public $result_errorspolicy_like_slp; /* SLP_Internal_Pol*/
	public $result_errorspolicy_like_catalog; /* Catalog-Backup */
	public $result_errorspolicy_like_unixfs; /* UNIX-FS */
	public $result_errorspolicy_like_unixoracle; /* UNIX-Oracle */
	public $result_errorspolicy_like_vmware; /* VMWARE */
	public $result_errorspolicy_like_windowsfs; /* Windows-FS */
	public $result_errorspolicy_like_windowsoracle; /* WIndows-ORACLE */
	public $result_errorspolicy_like_windowssql; /* WIndows-SQL */
	public $result_errorspolicy_like_others; /* Others */
	
	function errors_PolicyLikeDefined_ds__data($params) {
		require 'config-db.php';
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%SLP_%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_slp = $result->fetch_assoc();	
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%Catalog-Backup%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_catalog = $result->fetch_assoc();	
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%UNIX-FS%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_unixfs = $result->fetch_assoc();		
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%UNIX-Oracle%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_unixoracle = $result->fetch_assoc();
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%VMWARE%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_vmware = $result->fetch_assoc();
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%Windows-FS"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_windowsfs = $result->fetch_assoc();
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%Windows-Oracle%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_windowsoracle = $result->fetch_assoc();
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW() AND policy LIKE "%Windows-SQL%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_windowssql = $result->fetch_assoc();
		$sql = 'SELECT COUNT(*) as total FROM `errors` WHERE date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				AND policy NOT LIKE "%SLP_%" AND policy NOT LIKE "%UNIX-FS%" AND policy NOT LIKE "%UNIX-Oracle%"
				AND policy NOT LIKE "%VMWARE%" AND policy NOT LIKE "%Windows-FS%" AND policy NOT LIKE "%Windows-Oracle%"
				AND policy NOT LIKE "%Windows-SQL%"';
			$result = $conn->query($sql);
			$this->result_errorspolicy_like_others = $result->fetch_assoc();
	}
	function errors_PolicyLikeDefined_ds__graph($params) {
	echo '
			widgetTitle : "Porcentaje de Policys  '."$params[timeago]"." - $params[policy]".'",
			widgetId : "'."$params[name]".'",
			widgetType : "chart",
			widgetContent : {
			data : [
			{
			data : [[0, ' .$this->result_errorspolicy_like_slp["total"]. ']],
			label: "SLP_Internal"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_catalog["total"]. ']],
			label: "Catalog-Backup"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_unixfs["total"]. ']],
			label: "UNIX-FS"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_unixoracle["total"]. ']],
			label: "UNIX-Oracle"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_vmware["total"]. ']],
			label: "VMWARE"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_windowsfs["total"]. ']],
			label: "Windows-FS"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_windowsoracle["total"]. ']],
			label: "Windows-Oracle"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_windowssql["total"]. ']],
			label: "Windows-SQL"
		},{
			data : [[0, ' .$this->result_errorspolicy_like_others["total"]. ']],
			label: "Otros"
		}],
		options : {
        HtmlText : false,
        grid : {
                verticalLines : false,
                horizontalLines : false
        },
        xaxis : {
                showLabels : false
        },
        yaxis : {
                showLabels : false
        },
        pie : {
                show : true,
                explode : 6
        },
		mouse: {
			track: true,
			trackDecimals: 0,
			trackFormatter: function (obj) {
			return obj.series.label + ": " + obj.y;
			}
		},
        legend : {
                position : "se",
                backgroundColor : "#D2E8FF"
        }
		}
		}';
	}
}

class errors_FailedList_ds { // List of return status not 0 - multiple params possible
	public $result;
	
	
	function errors_FailedList_ds__data($params) {
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'SELECT status, client, policy, date FROM `errors`
		WHERE `client` IS NOT NULL AND date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
		AND status != "0"';
		}
		else {
			$sql = 'SELECT status, client, policy, date FROM `errors`
		WHERE `client` IS NOT NULL AND date BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
		AND `policy` LIKE "%'.$params['policy'].'%"
		AND status != "0"';
		}

		$this->result = $conn->query($sql);
	}
	function errors_FailedList_ds__table($params){ 
		echo '				
						widgetTitle : "Backups Fallidos '."$params[timeago]"." - $params[policy]".'",
						widgetId : "'."$params[name]".'",
						widgetType : "table",
						setJqueryStyle : true,
						widgetContent : {
						        "aaData" : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo "['" .$row['status']. "', '" .$row['client']. "', '" .$row['policy']. "', '" .$row['date']. "'],
					";
			}
			echo '],';
		}
		else{
			echo "['No hay', 'resultados', ' ', ' ', ' ', ' ']],
			";
		}
		echo '				                    "aoColumns" : [{
					                            "sTitle" : "Status"
					                    }, {
					                            "sTitle" : "Client"
					                    }, {
						                        "sTitle" : "Policy"
					                    }, {
							                    "sTitle" : "Date"
					                    }],
					                    "aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
					                    "iDisplayLength": 25,
					                    "bPaginate": true,
					                    "bAutoWidth": true
			}';
	}
	
}

?>