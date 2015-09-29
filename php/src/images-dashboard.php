<?php 

class images_RetentionLevelList_ds { // List of retention level - multiple params possible
	public $result;
	
	function images_RetentionLevelList_ds__data($params){
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'select ROUND((sum(kilobytes) / 1024) / 1024) AS gigabytes,retention_level from images
				WHERE `client` IS NOT NULL AND backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				group by retention_level
				ORDER BY gigabytes DESC';
		}
		else {
			$sql = 'select ROUND((sum(kilobytes) / 1024) / 1024) AS gigabytes,retention_level from images
				WHERE `client` IS NOT NULL AND backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				AND `policy` LIKE "%'.$params['policy'].'%"
				group by retention_level
				ORDER BY gigabytes DESC';
		}
		$this->result = $conn->query($sql);
	}
	
	function images_RetentionLevelList_ds__graph($params) {	
		echo '
			widgetTitle : "Gigabytes por Retention '."$params[timeago]"." - $params[policy]".'",
			widgetId : "'."$params[name]".'",
			widgetType : "chart",
			widgetContent : {
			data : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo '
					{
					data : [[0, ' .$row["gigabytes"]. ']],
					label: "' .$row["retention_level"]. '"
				},';
			}
		}
		else {
			echo '{
				data: [[0, 0]],
				label: "ERROR"
			},';
		}
		echo '	],
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
                explode : 10,
				labelFormatter : function (pie, slice) {
        			return slice;
      			}
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

class images_ClientImageInImages_ds { //List of clients in images - multiple params possible
	public $images_query_graph_in_client_images;
	public $images_query_graph_notin_client_images;
	
	function images_ClientImageInImages_ds__data($params){ 
		require 'config-db.php';
		if ($params['client'] == 'Any') {
			$sql = 'SELECT count(*) as total from client
				WHERE client IN
				(
				select client FROM images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				);';
				$result = $conn->query($sql); /* Lanzo la query */
				$this->images_query_graph_in_client_images = $result->fetch_assoc();
			$sql = 'SELECT count(*) as total from client
				WHERE client NOT IN
				(
				select client FROM images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				);';
				$result = $conn->query($sql); /* Lanzo la query */
				$this->images_query_graph_notin_client_images = $result->fetch_assoc();
		}
		else {
			$sql = 'SELECT count(*) as total from client
				WHERE client IN
				(
				select client FROM images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				)
				AND `client` LIKE "%'.$params['client'].'%";';
				$result = $conn->query($sql); /* Lanzo la query */
				$this->images_query_graph_in_client_images = $result->fetch_assoc();
			$sql = 'SELECT count(*) as total from client
				WHERE client NOT IN
				(
				select client FROM images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				)
				AND `client` LIKE "%'.$params['client'].'%";';
				$result = $conn->query($sql); /* Lanzo la query */
				$this->images_query_graph_notin_client_images = $result->fetch_assoc();
		} 
	}

	function images_ClientImageInImages_ds__graph($params) { 
	
		echo '
				widgetTitle : "Porcentaje de Clientes Backup '."$params[timeago]"." - $params[client]".'",
				widgetId : "'."$params[name]".'",
				widgetType : "chart",
				widgetContent : {
				data : [
				{
			data : [[0, ' .$this->images_query_graph_in_client_images["total"]. ']],
				label: "Con Backup"
			},{
				data : [[0, ' .$this->images_query_graph_notin_client_images["total"]. ']],
				label: "Sin Backup",
				pie : {
					explode : 10
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
	    	grid: {
	        	hoverable: false,
	        	clickable: false
	    	},
	        legend : {
	                position : "se",
	                backgroundColor : "#D2E8FF"
	        }
			}
			}';
	
	}
}

class images_PolicyListInImages_ds { //List of policys in images - multiple params possible
	public $result;

	function images_PolicyListInImages_ds__data($params){
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'SELECT `name`,`type`,`client` from policies
					WHERE active = "YES"
					AND `type` NOT LIKE "%Vault%"
					AND name NOT IN ( select policy FROM images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					);';
			$this->result = $conn->query($sql); /* Lanzo la query */
		}
		else {
			$sql = 'SELECT `name`,`type`,`client` from policies
					WHERE active = "YES"
					AND `type` NOT LIKE "%Vault%"
					AND `name` LIKE "%'.$params['policy'].'%"
					AND name NOT IN ( select policy FROM images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					);';
			$this->result = $conn->query($sql); /* Lanzo la query */
		}
	}

	function images_PolicyListInImages_ds__graph($params) {
		echo '				widgetTitle : "Listado de Policys sin Backup '."$params[timeago]"." - $params[policy]".'",
							widgetId : "'."$params[name]".'",
							widgetType : "table",
							setJqueryStyle : true,
							widgetContent : {
						        "aaData" : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo "['" .$row['name']. "', '" .$row['type']. "', '" .$row['client']. "'],
						";
			}
			echo '],';
		}
		else{
			echo "['No hay', 'resultados', ' ']],
				";
		}
		echo '				                    "aoColumns" : [{
						                            "sTitle" : "Policy"
						                    }, {
						                            "sTitle" : "Type"
						                    }, {
							                        "sTitle" : "Client"
						                    }],
						                    "aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
						                    "iDisplayLength": 50,
						                    "bPaginate": true,
						                    "bAutoWidth": true
				}';
	}
}

class images_ClientListInImages_ds { //List of clients in images - only timeago params possible
	public $result;

	function images_ClientListInImages_ds__data($params){
		require 'config-db.php';
			$sql = 'SELECT `client`,`hardware` from client 
					WHERE client NOT IN ( select client FROM images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
					);';
			$this->result = $conn->query($sql); /* Lanzo la query */	
	}

	function images_ClientListInImages_ds__graph($params) {
		echo '				widgetTitle : "Listado de Clientes sin Backup '."$params[timeago]".'",
							widgetId : "'."$params[name]".'",
							widgetType : "table",
							setJqueryStyle : true,
							widgetContent : {
						        "aaData" : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo "['" .$row['client']. "', '" .$row['hardware']. "'],
						";
			}
			echo '],';
		}
		else{
			echo "['No hay', 'resultados']],
				";
		}
		echo '				                    "aoColumns" : [{
						                            "sTitle" : "Client"
						                    }, {
						                            "sTitle" : "Hardware"
						                    }],
						                    "aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
						                    "iDisplayLength": 50,
						                    "bPaginate": true,
						                    "bAutoWidth": true
				}';
		}
}

class images_ConsumeClientList_ds { //List consume of clients - multiple params possible
	public $result;
	
	function images_ConsumeClientList_ds__data($params){
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'select client,
				ROUND((sum(kilobytes) / 1024 / 1024),2) AS gigabytes,
				ROUND(sum(elapsed_time) / 60) as minutes,
				(format((SUM(kilobytes) / 1024) / SUM(elapsed_time),2)) AS mbs,
				count(*) AS images
				from images
				WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				group by client order by gigabytes DESC;';
		}
		else {
			$sql = 'select client,
				ROUND((sum(kilobytes) / 1024 / 1024),2) AS gigabytes,
				ROUND(sum(elapsed_time) / 60) as minutes,
				(format((SUM(kilobytes) / 1024) / SUM(elapsed_time),2)) AS mbs,
				count(*) AS images
				from images
				WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				AND `policy` LIKE "%'.$params['policy'].'%"
				group by client order by gigabytes DESC;';
		}
		$this->result = $conn->query($sql);
	}
	
	function images_ConsumeClientList_ds__table($params){ 
		echo '				widgetTitle : "Consumo Cliente de Backups '."$params[timeago]"." - $params[policy]".'",
							widgetId : "'."$params[name]".'",
							widgetType : "table",
							setJqueryStyle : true,
							widgetContent : {
						        "aaData" : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo "['" .$row['client']. "', '" .$row['gigabytes']. "', '" .$row['minutes']. "', '" .$row['mbs']. "', '" .$row['images']. "'],
						";
			}
			echo '],';
		}
		else{
			echo "['No hay', 'resultados', ' ', ' ', ' ', ' ']],
				";
		}
		echo '				                    "aoColumns" : [{
						                            "sTitle" : "Client"
						                    }, {
						                            "sTitle" : "Gigabytes"
						                    }, {
							                        "sTitle" : "Minutes"
						                    }, {
								                    "sTitle" : "MB/S"
						                    }, {
						                            "sTitle" : "Imagenes"
						                    }],
						                    "aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
						                    "iDisplayLength": 50,
						                    "bPaginate": true,
						                    "bAutoWidth": true
				}';
	}
}

class images_ConsumePolicyList_ds { //List consume of policys - multiple params possible
	public $result;
	
	function images_ConsumePolicyList_ds__data($params){ 
		require 'config-db.php'; 
		
		if ($params['policy'] == 'Any') {
			$sql = 'select policy,
				ROUND((sum(kilobytes) / 1024 / 1024),2) AS gigabytes,
				ROUND(sum(elapsed_time) / 60) as minutes,
				(format((SUM(kilobytes) / 1024) / SUM(elapsed_time),2)) AS mbs
				from images
				WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				group by policy;';	
		}
		else {
			$sql = 'select policy,
				ROUND((sum(kilobytes) / 1024 / 1024),2) AS gigabytes,
				ROUND(sum(elapsed_time) / 60) as minutes,
				(format((SUM(kilobytes) / 1024) / SUM(elapsed_time),2)) AS mbs
				from images
				WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				AND `policy` LIKE "%'.$params['policy'].'%"
				group by policy;';
		}
		$this->result = $conn->query($sql); 
	}
	function images_ConsumePolicyList_ds__table($params){ 
		echo '				widgetTitle : "Consumo Policy '."$params[timeago]"." - $params[policy]".'",
						widgetId : "'."$params[name]".'",
						widgetType : "table",
						setJqueryStyle : true,
						widgetContent : {
					        "aaData" : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo "['" .$row['policy']. "', '" .$row['gigabytes']. "', '" .$row['minutes']. "', '" .$row['mbs']. "'],
					";
			}
			echo '],';
		}
		else{
			echo "['No hay', 'resultados', ' ', ' ', ' ', ' ']],
			";
		}
		echo '				                    "aoColumns" : [{
					                            "sTitle" : "Policy"
					                    }, {
					                            "sTitle" : "Gigabytes"
					                    }, {
						                        "sTitle" : "Minutes"
					                    }, {
							                    "sTitle" : "MB/S"
					                    }],
					                    "aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
					                    "iDisplayLength": 50,
					                    "bPaginate": true,
					                    "bAutoWidth": true
			}';
	}
	
}

class images_ListGroupHour_ds { //List consume by hour - multiple params possible
	public $result;
	
	function images_ListGroupHour_ds__data($params){  
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'select hour(backup_time) AS hour,
				date(backup_time) AS day,
				ROUND((sum(kilobytes) / 1024 / 1024),2) AS gigabytes,
				(format(SUM(kilobytes) / SUM(elapsed_time),2)) AS mbs,
				count(*) AS images
				from images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				group by hour(backup_time)
				ORDER BY day, hour;';
		}
		else {
			$sql = 'select hour(backup_time) AS hour,
				date(backup_time) AS day,
				ROUND((sum(kilobytes) / 1024 / 1024),2) AS gigabytes,
				(format(SUM(kilobytes) / SUM(elapsed_time),2)) AS mbs,
				count(*) AS images
				from images WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
				AND `policy` LIKE "%'.$params['policy'].'%"
				group by hour(backup_time)
				ORDER BY day, hour;';
		}	
		$this->result = $conn->query($sql); /* Lanzo la query */
	}
	
	function images_ListGroupHour_ds__table($params){ 
		echo '				widgetTitle : "Consumo y Tiempos Backups '."$params[timeago]"." - $params[policy]".'",
						widgetId : "'."$params[name]".'",
						widgetType : "table",
						setJqueryStyle : true,
						widgetContent : {
					        "aaData" : [';
		global $result; /*levanto la variable global*/
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo "['" .$row['hour']. "', '" .$row['gigabytes']. "', '" .$row['mbs']. "', '" .$row['images']. "'],
					";
			}
			echo '],';
		}
		else{
			echo "['No hay', 'resultados', ' ', ' ', ' ', ' ']],
			";
		}
		echo '				                    "aoColumns" : [{
					                            "sTitle" : "Hour"
					                    }, {
					                            "sTitle" : "Gigabytes"
					                    }, {
							                    "sTitle" : "MB/s"
					                    }, {
					                            "sTitle" : "Imagenes"
					                    }],
					                    "aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
					                    "iDisplayLength": 25,
					                    "bPaginate": true,
					                    "bAutoWidth": true
			}';
	}
	
}

class images_PolicyLikeList_ds { //List consume by Policy like pie - multiple params possible
	public $result;
	
	function images_ClientLikeList_ds__data($params){
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
		$sql = 'select ROUND((sum(kilobytes) / 1024 / 1024)) AS gigabytes,
			client
			from images
			WHERE `client` IS NOT NULL AND
			backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
			group by client
			ORDER BY gigabytes DESC
			LIMIT 30';
		}
		else {
			$sql = 'select ROUND((sum(kilobytes) / 1024 / 1024)) AS gigabytes,
			client
			from images
			WHERE `client` IS NOT NULL AND
			backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
			AND `policy` LIKE "%'.$params['policy'].'%"
			group by client
			ORDER BY gigabytes DESC';			
		}
		$this->result = $conn->query($sql);
	}
	function images_ClientLikeList_ds__graph($params) { 
		echo '
			widgetTitle : "Gigabytes por cliente '."$params[timeago]"." - $params[policy]".'",
			widgetId : "'."$params[name]".'",
			widgetType : "chart",
			widgetContent : {
			data : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo '
					{
					data : [[0, ' .$row["gigabytes"]. ']],
					label: "' .$row["client"]. '"
				},';
			}
		}
		else {
			echo '{
				data: [[0, 0]],
				label: "ERROR"
			},';
		}
		echo '	],
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
                explode : 6,
				labelFormatter : function (pie, slice) {
        			return slice;
      			}
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

class images_ConsumeHistoricAllDaily { //List historic consume chart browse - multiple params possible
	public $result;
	public $type;
	public $timeformat;

	function images_ConsumeHistoricAllDaily__params($params) {
		switch ($params['type']) { //switch for different date format filter
			case "hour":
				$this->type = "%Y-%m-%d %H:00:00";
				$this->timeformat = "%h hs";
				break;
			case "day":
				$this->type = "%Y-%m-%d";
				$this->timeformat = "%d-%b";
				break;
			case "month":
				$this->type = "%Y-%m";
				$this->timeformat = "%d-%b";
				break;
		}
	}
	function images_ConsumeHistoricAllDaily__data($params) {
		require 'config-db.php'; 

		if ($params['policy'] == 'Any') {
			$sql = 'SELECT UNIX_TIMESTAMP(CONVERT_TZ(DATE_FORMAT(backup_time, "'.$this->type.'"),"+00:00","-04:00")) AS date,
			ROUND((sum(kilobytes) / 1024 / 1024),0) AS gigabytes
			FROM images
			WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
			GROUP BY date
			ORDER BY date ASC;';
		}
		else {
			$sql = 'SELECT UNIX_TIMESTAMP(CONVERT_TZ(DATE_FORMAT(backup_time, "'.$this->type.'"),"+00:00","-04:00")) AS date,
			ROUND((sum(kilobytes) / 1024 / 1024),0) AS gigabytes
			FROM images
			WHERE backup_time BETWEEN NOW() - INTERVAL '."$params[timeago]".' AND NOW()
			AND `policy` LIKE "%'.$params['policy'].'%"
			GROUP BY date
			ORDER BY date ASC;';
		}
		$this->result = $conn->query($sql);
	}	

	function images_ConsumeHistoricAllDaily__js($params) {
		echo '<script type="text/javascript">
		'."$params[name]".' = function() {
		var
		d2 = [],
		start = new Date("2013/01/01 00:00").getTime(),
		options, graph, i, x, o;
		';
	
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo 'd2.push([' . $row["date"]. ', ' . $row["gigabytes"]. '])
						';
			}
		} else {
			echo 'd2.push([0, 0])';
		}
		echo '
			return [d2];
			};
		</script>';
	}

	function images_ConsumeHistoricAllDaily__graph($params) {
		echo '
					widgetTitle : "Consumo Historico '."$params[timeago]"." - $params[policy]".'",
					widgetId : "'."$params[name]".'",
					widgetType : "chart",
					getDataBySelection : true,
					widgetContent : {
						data : '."$params[name]".'(),
						options : {
					        xaxis: {
					            mode: "time",
				    			timeFormat: "'."$this->timeformat".'",
						        timeUnit: "second",
					            labelsAngle: 45
					        },
							grid : {
								minorVerticalLines : true
							},
				    		yaxis: {
				    			title: "Gigabytes"
				    		},
					        selection: {
					            mode: "x"
					        },
							mouse: {
								track: true,
								trackDecimals: 0,
								trackFormatter: function (obj) {
									return obj.x + ": " + obj.y;
								}
							},
					        HtmlText: false
						}
					}';
	}
	
}	

?>