<?php 
/**
 * FUNCIONES
 */

class clientname_table_nb { //clientname list detailed
	public $paramsQuery;
	public $result;

	function clientname_table_nb__params(){ /* utilizada unicamente para remplazar los parametros enviados*/
		if(isset($_GET['pclient'])) { /* nombre del cliente a buscar */
			$cQuery = " AND `client` LIKE '%".$_GET['pclient']."%'";
			$this->paramsQuery=$this->paramsQuery.$cQuery;
		}
		if(isset($_GET['pos'])) { /* nombre del os a buscar */
			$oQuery = " AND `os` LIKE '%".$_GET['pos']."%'";
			$this->paramsQuery=$this->paramsQuery.$oQuery;
		}
		if(isset($_GET['phardware'])) { /* nombre del hardware a buscar */
			$hQuery = " AND `hardware` LIKE '%".$_GET['phardware']."%'";
			$this->paramsQuery=$this->paramsQuery.$hQuery;
		}
		if(isset($_GET['plimit'])) { /* cantidad de resultados query, debe ir al final */
			$lQuery = " LIMIT ".$_GET['plimit'];
			$this->paramsQuery=$this->paramsQuery.$lQuery;
		}
	}
	
	function clientname_table_nb__data(){  /*coneccion sql*/
		$sql = "SELECT * FROM `client` WHERE `client` IS NOT NULL".$this->paramsQuery;
		require 'config-db.php'; /* Configuracion de Base de Datos */
		$this->result = $conn->query($sql); /* Lanzo la query */
	}
	
	function clientname_table_nb__table() { /*dibujo tabla*/
		if ($this->result->num_rows > 0) {
			echo "<table id='tb' class='display' width='100%' cellspacing='0'>
		<thead>
			<tr>
				<th>Hardware</th>
				<th>Operating System</th>
				<th>Client Name</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Hardware</th>
				<th>Operating System</th>
				<th>Client Name</th>
			</tr>
		</tfoot>
	<tbody>";
			// output data of each row
			while($row = $this->result->fetch_assoc()) {
				echo "<tr>
					<td>" . $row["hardware"]. "</td>
					<td>" . $row["os"]. "</td>
					<td>" . $row["client"]. "</td>
				</tr>";
			}
			echo "
	</tbody>
	</table>";
		} else {
			echo "0 results";}
	}
}

class clientname_oslike_nb {	//clientname os like detailed
	public $result_clientos_like_hp = '0'; //assign 0 by default
	public $result_clientos_like_aix = '0'; //assign 0 by default
	public $result_clientos_like_virtual = '0'; //assign 0 by default
	public $result_clientos_like_windows = '0'; //assign 0 by default
	public $result_clientos_like_others = '0'; //assign 0 by default
	
	function clientname_oslike_nb__data() { /* valores para grafico */
		include 'config-db.php'; /* Configuracion de Base de Datos */
		/* declaro variables globales para incluir en el grafico */

		/* HP */
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%HP%'";
		$result = $conn->query($sql);
		$this->result_clientos_like_hp = $result->fetch_assoc();
		/* AIX */
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%AIX%'";
		$result = $conn->query($sql);
		$this->result_clientos_like_aix = $result->fetch_assoc();
		/* VIRTUAL */
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%VIRTUAL%'";
		$result = $conn->query($sql);
		$this->result_clientos_like_virtual = $result->fetch_assoc();
		/* WIN */
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` LIKE '%WINDOWS%'";
		$result = $conn->query($sql);
		$this->result_clientos_like_windows = $result->fetch_assoc();
		/* OTHERS */
		$sql = "SELECT COUNT(*) as total FROM `client` WHERE `os` NOT LIKE '%HP%'
		 			AND `os` NOT LIKE '%AIX%' AND `os` NOT LIKE '%WIN%'
		 			AND `os` NOT LIKE '%VIRTUAL%' ";
	
		$result = $conn->query($sql);
		$this->result_clientos_like_others = $result->fetch_assoc();
	}
	
	function clientname_oslike_nb__draw() { /* grafico */
		echo '
	<div id="flotr2_pie_client_graph_os"></div>
	
	    <script type="text/javascript">
	    (function basic_pie(container) {
	
	        graph = Flotr.draw(container, [
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
	                explode: 10
	            },
				mouse: {
					track: true,
					trackDecimals: 0,
					trackFormatter: function (obj) {
					return obj.series.label + ": " + obj.y;   
					}
				},
	            legend: {
	                position: "se",
	                backgroundColor: "#D2E8FF"
	            },
	            title: "Clientname Graph",
	        	subtitle: "Listado de clientes"
	        });
	
	    })(document.getElementById("flotr2_pie_client_graph_os"));
			</script>';
	}
}

?>