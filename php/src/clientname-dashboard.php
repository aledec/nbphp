<?php
class clientname_oslike_ds { //clientname dashboard pie graph os like
	public $result_clientos_like_hp = '0'; 		/* HP */
	public $result_clientos_like_aix = '0';		/* AIX */
	public $result_clientos_like_virtual = '0';	/* VIRTUAL */
	public $result_clientos_like_windows = '0';	/* WIN */
	public $result_clientos_like_others = '0'; 	/* OTHERS */
	

	function clientname_oslike_ds__data() { /* valores para grafico */
		require 'config-db.php';
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%HP%'";
			$result = $conn->query($sql);
			$this->result_clientos_like_hp = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%AIX%'";
			$result = $conn->query($sql);
			$this->result_clientos_like_aix = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%VIRTUAL%'";
			$result = $conn->query($sql);
			$this->result_clientos_like_virtual = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%WINDOWS%'";
			$result = $conn->query($sql);
			$this->result_clientos_like_windows = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` NOT LIKE '%HP%'
		 			AND `os` NOT LIKE '%AIX%' AND `os` NOT LIKE '%WIN%'
		 			AND `os` NOT LIKE '%VIRTUAL%' ";
			$result = $conn->query($sql);
			$this->result_clientos_like_others = $result->fetch_assoc();
	}
	function clientname_graph_os_ds__draw() { /*utilizada para clientname unicamente en el dashboard*/
		echo '
				widgetTitle : "Porcentaje de Clientes (Operating System)",
				widgetId : "client_data_graph_os",
				widgetType : "chart",
				getDataBySelection: "true",
				widgetContent : {
				data : [
				{
				data : [[0, ' .$this->result_clientos_like_hp["total"]. ']],
				label: "HP-UX"
			},{
				data : [[0, ' .$this->result_clientos_like_aix["total"]. ']],
				label: "AIX"
			},{
				data : [[0, ' .$this->result_clientos_like_virtual["total"]. ']],
				label: "Virtual"
			},{
				data : [[0, ' .$this->result_clientos_like_windows["total"]. ']],
				label: "Windows"
			},{
				data : [[0, ' .$this->result_clientos_like_others["total"]. ']],
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

class clientname_table_ds { //clientname dashboard table list
	public $result = 0;
	
	function clientname_table_ds__data(){ 
		$sql = "SELECT * FROM `client` WHERE `client` IS NOT NULL";
		require 'config-db.php';
		$this->result = $conn->query($sql);
	}
	
	function clientname_table_ds__table(){
		echo '
							widgetTitle : "Listado de Clientes",
							widgetId : "client_data_table",
							widgetType : "table",
							setJqueryStyle : true,
							widgetContent : {
						        "aaData" : [';
		if ($this->result->num_rows > 0) {
			while($row = $this->result->fetch_assoc()) {
				echo "['" .$row['hardware']. "', '" .$row['os']. "', '" .$row['client']. "'],
				";
			}
			echo '],';
		}
		else{
			echo "['No hay', 'resultados', ' ']],
				";
		}
		echo '				                    "aoColumns" : [{
						                            "sTitle" : "hardware"
						                    }, {
						                            "sTitle" : "os"
						                    }, {
						                            "sTitle" : "client"
						                    }],
						                    "iDisplayLength": 25,
						                    "aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
						                    "bPaginate": true,
						                    "bAutoWidth": false
				}';
	}
	
}

?>