<?php 

/**
 * FUNCIONES
 */
class policy_table_nb {
	public $paramsQuery = "";
	public $result;

	function policy_table_nb__params() { /* utilizada unicamente para remplazar los parametros enviados*/
		if(isset($_GET['ptype'])) { /* levanto el condicional de cantidad de tiempo previo */
			$tQuery = " AND type LIKE '%".$_GET['ptype']."%'";
			$this->paramsQuery=$this->paramsQuery.$tQuery;
		}
		if(isset($_GET['pclientname'])) { /* nombre del cliente a buscar */
			$cQuery = " AND `client` LIKE '%".$_GET['pclientname']."%'";
			$this->paramsQuery=$this->paramsQuery.$cQuery;
		}
		if(isset($_GET['pactive'])) { /* status del cliente, si no es 0 buscar*/
			$aQuery = " AND `active` LIKE '%".$_GET['pactive']."%'";
			$this->paramsQuery=$this->paramsQuery.$aQuery;
		}
		if(isset($_GET['plimit'])) { /* cantidad de resultados query, debe ir al final */
			$lQuery = " LIMIT ".$_GET['plimit'];
			$this->paramsQuery=$this->paramsQuery.$lQuery;
		}
		//$paramsQuery=$tQuery.$cQuery.$aQuery.$lQuery; /*asigno instruccion sql de parametros*/
	}
	function policy_table_nb__data() { /*coneccion sql*/
		//$sql = "SELECT * FROM `policies` WHERE `client` IS NOT NULL".$tQuery.$cQuery.$aQuery.$lQuery; /* Query */
		$sql = "SELECT * FROM `policies` WHERE `client` IS NOT NULL".$this->paramsQuery;
		require 'config-db.php'; /* Configuracion de Base de Datos */
		$this->result = $conn->query($sql); /* Lanzo la query */
	}
	function policy_table_nb__table() { /*dibujo tabla*/
		if ($this->result->num_rows > 0) {
			echo "<table id='tb' class='display table table-striped table-bordered' width='100%' cellspacing='0'>
	 		<thead>
	 			<tr>
					<th>Name</th>
					<th>Type</th>
					<th>Template</th>
					<th>Active</th>
					<th>Active Since</th>
					<th>Client</th>
				</tr>
	 		</thead>
					
	 		<tfoot>
	 			<tr>
					<th>Name</th>
					<th>Type</th>
					<th>Template</th>
					<th>Active</th>
					<th>Active Since</th>
					<th>Client</th>
				</tr>
	 		</tfoot>				
	 		<tbody>";
			// output data of each row
			while($row = $this->result->fetch_assoc()) {
				$aColor = $aTemplate = $aType = "white";
				if($row["active"] == "yes") { /* for policy boolean */
					$aActive = "#9AFE2E";}
				else if($row["active"] == "no") {
						$aActive = '#F3F781';}
				if($row["template"] == "yes"){ /* if policy active */
					$aTemplate = "#F79F81";}
				if (strpos($row["type"], "SAP") === TRUE) { /* for string SAP */
					$aType = "#F3E2A9";}
				else if (strpos($row["type"], "Standard") === TRUE) {
					$aType = '#ECCEF5';} 
				else {
					$aType = '#D8CEF6';}
			
				echo "<tr>
					<td>" . $row["name"]. "</td>
					<td>" . $row["type"]. "</td>
					<td>" . $row["template"]. "</td>
					<td style='background-color:".$aActive."'>" . $row["active"]. "</td>
					<td>" . $row["active_since"]. "</td>
					<td>" . $row["client"]. "</td>
				</tr>";
			}
			echo "</tbody>
			</table>";
		} else {
			echo "0 results";
		}
	}

}

class policy_active_nb {
	public $result_policy_active_yes = '0'; // valor si, asigno 0 por defecto
	public $result_policy_active_no = '0'; //valor no, asigno 0 por defecto
	
	function policy_active_nb__data() { /* valores para grafico */
		require 'config-db.php'; /* Configuracion de Base de Datos */
		/* YES */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `active` LIKE '%yes%'";
		$result = $conn->query($sql);
		$this->result_policy_active_yes = $result->fetch_assoc();
	
		/* NO */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `active` LIKE '%no%'";
		$result = $conn->query($sql);
		$this->result_policy_active_no = $result->fetch_assoc();
	}

	function policy_active_nb__draw() { /* grafico */	
		/*incluir en la pagina para graficar en este div, ejemplo onclick*/
		/* <div id="editor-render-0"></div> */
		echo '
	<div id="flotr2_pie_policy_active"></div>
	
	    <script type="text/javascript">
	    (function basic_pie(container) {
	
	        graph = Flotr.draw(container, [
			{
				data : [[0, ' .$this->result_policy_active_yes["total"]. ']],
				label: "Activa"
			},{
				data : [[0, ' .$this->result_policy_active_no["total"]. ']],
				label: "Inactiva"
			}],
	        {
	            HtmlText: false,
	            grid: {
	                verticalLines: true,
	                horizontalLines: true
	            },
	            xaxis: {
	                showLabels: false
	            },
	            yaxis: {
	                showLabels: false
	            },
	            pie: {
	                show: true,
	                explode: 6
	            },
				mouse: {
					track: true,
					trackFormatter: function (obj) {
					return obj.series.label + ": " + obj.y;
					}
				},
	            legend: {
	                position: "se",
	                backgroundColor: "#D2E8FF"
	            },
	            title: "PolicyType Graph",
	        	subtitle: "Tipos de Policys"
	        });
	
	    })(document.getElementById("flotr2_pie_policy_active"));
			</script>';
	}
}

class policy_type_like_nb {
	public $result_policy_type_like_oracle = '0'; // assign 0 as type value
	public $result_policy_type_like_sap = '0'; // assign 0 as type value
	public $result_policy_type_like_sql = '0'; // assign 0 as type value
	public $result_policy_type_like_ms = '0'; // assign 0 as type value
	public $result_policy_type_like_vmware = '0'; // assign 0 as type value
	public $result_policy_type_like_standard = '0'; // assign 0 as type value
	public $result_policy_type_like_others = '0'; // assign 0 as type value
	
	function policy_type_like_nb__data() { /* valores para grafico */
		require 'config-db.php'; /* Configuracion de Base de Datos */
		/* ORACLE */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%oracle%'";
		$result = $conn->query($sql);
		$this->result_policy_type_like_oracle = $result->fetch_assoc();
		/* SAP */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%sap%'";
		$result = $conn->query($sql);
		$this->result_policy_type_like_sap = $result->fetch_assoc();
		/* SQL */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%sql%'";
		$result = $conn->query($sql);
		$this->result_policy_type_like_sql = $result->fetch_assoc();
		/* MS */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%ms%'";
		$result = $conn->query($sql);
		$this->result_policy_type_like_ms = $result->fetch_assoc();
		/* VMWARE */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%vmware%'";
		$result = $conn->query($sql);
		$this->result_policy_type_like_vmware = $result->fetch_assoc();
		/* STANDARD */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%standard%'";
		$result = $conn->query($sql);
		$this->result_policy_type_like_standard = $result->fetch_assoc();
		/* OTHERS */
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` NOT LIKE '%oracle%'
		 			AND `type` NOT LIKE '%sap%' AND `type` NOT LIKE '%sql%'
		 			AND `type` NOT LIKE '%ms%'  AND `type` NOT LIKE '%vmware%'
					AND `type` NOT LIKE '%standard%'";
		$result = $conn->query($sql);
		$this->result_policy_type_like_others = $result->fetch_assoc();
	}
	
	function policy_type_like_nb__draw() { /* grafico */
		echo '
	<div id="flotr2_pie_policy_type_like"></div>
	
	    <script type="text/javascript">
	    (function basic_pie(container) {
	
	        graph = Flotr.draw(container, [
			{
				data : [[0, ' .$this->result_policy_type_like_oracle["total"]. ']],
				label: "Oracle"
			},{
				data : [[0, ' .$this->result_policy_type_like_sap["total"]. ']],
				label: "SAP"
			},{
				data : [[0, ' .$this->result_policy_type_like_sql["total"]. ']],
				label: "SQL"
			},{
				data : [[0, ' .$this->result_policy_type_like_ms["total"]. ']],
				label: "Microsoft"
			},{
				data : [[0, ' .$this->result_policy_type_like_vmware["total"]. ']],
				label: "VMWare"
			},{
				data : [[0, ' .$this->result_policy_type_like_standard["total"]. ']],
				label: "Standard"
			},{
				data : [[0, ' .$this->result_policy_type_like_others["total"]. ']],
				label: "Otros"
			}],
	        {
	            HtmlText: false,
	            grid: {
	                verticalLines: true,
	                horizontalLines: true
	            },
	            xaxis: {
	                showLabels: false
	            },
	            yaxis: {
	                showLabels: false
	            },
	            pie: {
	                show: true,
	                explode: 6
	            },
		        mouse: {
		            track: true,
					trackDecimals: 0,
		            trackFormatter: function (obj) {
		                return obj.series.label + ": " + obj.y;
		            }
		        },
	    		grid: {
	        		hoverable: true,
	       		 	clickable: true
	    		},
	            legend: {
	                position: "se",
	                backgroundColor: "#D2E8FF"
	            },
	            title: "PolicyType Graph",
	        	subtitle: "Tipos de Policys"
	        });
	
	    })(document.getElementById("flotr2_pie_policy_type_like"));
			</script>';
	}
}
/**
 *  Inicio Formulario
 */
?>