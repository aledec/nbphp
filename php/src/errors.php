<?php
/**
 * FUNCIONES
 */

class errors_table_nb {
	public $paramsQuery = "";
	public $lQuery;
	public $result;
	public $name = 'nombre ';
	public $timeago = 'tiempohace ';
	public $type = 'tipo ';
	
	function variables($arr) {
		if(isset($arr['graphname'])){
			$name = $arr['name'];
		}
		if(isset($arr['timeago'])){
			$timeago = $arr['timeago'];
		}
		if(isset($arr['type'])){
			$type = $arr['type'];
		}
		echo $this->name;
		echo $this->timeago;
		echo $this->type;
	}
	
	function errors_table_nb__params() { /* utilizada unicamente para remplazar los parametros enviados*/
			if(isset($_GET['ptimeago'])) { /* levanto el condicional de cantidad de tiempo previo */
				$tQuery = " AND date BETWEEN NOW() - INTERVAL '" .$_GET['ptimeago']."' HOUR AND NOW()";
				$this->paramsQuery=$tQuery;
			}
			if(isset($_GET['pclientname'])) { /* nombre del cliente a buscar */
				$cQuery = " AND `client` LIKE '%".$_GET['pclientname']."%'";
				$this->paramsQuery=$this->paramsQuery.$cQuery;
			}
			if(isset($_GET['pnstatus'])) { /* status del cliente, si no es 0 buscar*/
				$sQuery = " AND status != '0'";
				$this->paramsQuery=$this->paramsQuery.$sQuery;
			}
			if(isset($_GET['plimit'])) { /* cantidad de resultados query, debe ir al final */
				$this->lQuery = " LIMIT ".$_GET['plimit'];
			}
	}

	function errors_table_nb__data() { /*coneccion sql*/
		if(isset($_GET['pfunction'])) { /* selecciono la sentencia sql a usar, por ejemplo, para hacer busquedas especiales*/
			switch ($_GET['pfunction']) {
				case "errors_view":
					$sql = "SELECT * FROM `errors` WHERE `client` IS NOT NULL".$this->paramsQuery.$this->lQuery;
					break;
				case "errors_time":
					$sql = "SELECT * FROM `errors` WHERE `date` IS NOT NULL".$this->paramsQuery." ORDER BY `date` DESC".$this->lQuery; /* Query */
					break;
				default:
					echo "No se ha seleccionado ninguna funcion valida";
					exit;
			}
		}
		require 'config-db.php'; /* Configuracion de Base de Datos */
		$this->result = $conn->query($sql); /* Lanzo la query */
	}

	function errors_table_nb__table() { /*dibujo tabla*/
		if ($this->result->num_rows > 0) {
			echo "<table id='tb' class='display table table-striped table-bordered' width='100%' cellspacing='0'>
		<thead>
			<tr>
				<th>Status</th>
				<th>Client</th>
				<th>Policy</th>
				<th>Type</th>
				<th>Backup Date</th>
				<th>Result</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Status</th>
				<th>Client</th>
				<th>Policy</th>
				<th>Type</th>
				<th>Backup Date</th>
				<th>Result</th>
			</tr>
		</tfoot>
		<tbody>";
			// output data of each row
			while($row = $this->result->fetch_assoc()) {
				if($row["status"] == "0"){
					$aStatus = "green";}
				else if($row["status"] == "1"){
					$aStatus = 'yellow';}
				elseif($row["status"] >= "2"){
					$aStatus = "orange";}
				echo "<tr>
					<td style='background-color:".$aStatus."'>" . $row["status"]. "</td>
					<td>" . $row["client"]. "</td>
					<td>" . $row["policy"]. "</td>
					<td>" . $row["type"]. "</td>
					<td>" . $row["date"]. "</td>
					<td>" . $row["result"]. "</td>";
							echo "</tr>";
			}
			echo "</tbody></table>";
	
		} else {
			echo "0 results";
		}
	}
}

?>