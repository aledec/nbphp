<?php 
/**
 * FUNCIONES
 */
function images_params() { /* utilizada unicamente para remplazar los parametros enviados*/
		global $paramsQuery; /*levanto la variable global*/
		$paramsQuery=null;
		global $lQuery;
		$lQuery=null; //declaro para evitar errores en querys con limit
		if(isset($_GET['ptimeago'])) { /* levanto el condicional de cantidad de tiempo previo */
			$tQuery = " AND backup_time BETWEEN NOW() - INTERVAL '" .$_GET['ptimeago']."' HOUR AND NOW()";
			$paramsQuery=$paramsQuery.$tQuery;
		}
		if(isset($_GET['pclientname'])) { /* nombre del cliente a buscar */
			$cQuery = " AND `client` LIKE '%".$_GET['pclientname']."%'";
			$paramsQuery=$paramsQuery.$cQuery;
		}
		if(isset($_GET['pnstatus'])) { /* status del cliente, si no es 0 buscar*/
			$sQuery = " AND status != '0'";
			$paramsQuery=$paramsQuery.$sQuery;
		}
		if(isset($_GET['plimit'])) { /* cantidad de resultados query, debe ir al final */
			global $lQuery;
			$lQuery = " LIMIT ".$_GET['plimit'];
		}
		//$paramsQuery=$tQuery.$cQuery.$sQuery.$aQuery; /*asigno instruccion sql de parametros*/
}

/**
 * Querys SQL
 */
function images_query_view() { /*coneccion sql*/
	global $paramsQuery;
	global $lQuery;
	if(isset($_GET['pfunction'])) { /* selecciono la sentencia sql a usar, por ejemplo, para hacer busquedas especiales*/
		switch ($_GET['pfunction']) {
			case "images_view":
				$sql = "SELECT * FROM `images` WHERE `client` IS NOT NULL".$paramsQuery.$lQuery; 
				break;
			case "images_time":
				$sql = "SELECT * FROM `images` WHERE `backup_time` IS NOT NULL".$paramsQuery." ORDER BY `elapsed_time` DESC".$lQuery; /* Query */
				break;
			case "images_kb":
				$sql = "SELECT * FROM `images` WHERE `kilobytes` IS NOT NULL".$paramsQuery." ORDER BY `kilobytes` DESC".$lQuery; /* Query */
				break;
			case "images_prom":
				echo "Funcion aun no armada";
				exit;
			default:
				echo "No se ha seleccionado ninguna funcion valida";
				exit;
		}
		echo $sql;
	}
	include 'config-db.php'; /* Configuracion de Base de Datos */
	global $result;  /*levanto la variable global*/
	$result = $conn->query($sql); /* Lanzo la query */
}

function images_query_graph_consume_total_all_daily() {  /* obtiene listado de total consumido historico por dia */
	$sql = "SELECT UNIX_TIMESTAMP(CONVERT_TZ(DATE_FORMAT(backup_time, '%Y-%m-%d'),'+00:00','-04:00')) AS date, 
			ROUND((sum(kilobytes) / 1024 / 1024),0) AS gigabytes 
			FROM images 
			GROUP BY date 
			ORDER BY date ASC;";
	include 'config-db.php'; /* Configuracion de Base de Datos */
	global $result;  /*levanto la variable global*/
	$result = $conn->query($sql); /* Lanzo la query */
}
function images_query_graph_consume_total_all_hour() {  /* obtiene listado de total consumido historico por dia */
	$sql = "SELECT UNIX_TIMESTAMP(CONVERT_TZ(DATE_FORMAT(backup_time, '%Y-%m-%d %H:00:00'),'+00:00','-04:00')) AS date, 
			ROUND((sum(kilobytes) / 1024 / 1024),0) AS gigabytes 
			FROM images 
			GROUP BY date 
			ORDER BY date ASC;";
	include 'config-db.php'; /* Configuracion de Base de Datos */
	global $result;  /*levanto la variable global*/
	$result = $conn->query($sql); /* Lanzo la query */
}

function images_query_graph_consume_1d() {  /* obtiene listado de total consumido historico por dia */
	$sql = "SELECT UNIX_TIMESTAMP(CONVERT_TZ(DATE_FORMAT(backup_time, '%Y-%m-%d %H:00:00'),'+00:00','-04:00')) AS date, 
			ROUND((sum(kilobytes) / 1024 / 1024),0) AS gigabytes 
			FROM images 
			WHERE backup_time > DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
			GROUP BY date 
			ORDER BY date ASC;";
	include 'config-db.php'; /* Configuracion de Base de Datos */
	global $result;  /*levanto la variable global*/
	$result = $conn->query($sql); /* Lanzo la query */
}

/**
 * Tablas de datatables, dibujo
 */
function images_table() { /*dibujo tabla*/
global $result; /*levanto la variable global*/
if ($result->num_rows > 0) {
	echo "<table id='tb' class='display table table-striped table-bordered' width='100%' cellspacing='0'>
	<thead>
		<tr>
			<th>Backup ID</th>
			<th>Client</th>
			<th>Policy</th>
			<th>Schedule</th>
			<th>Retention</th>
			<th>Status</th>
			<th>Backup Time</th>
			<th>Elapsed Time</th>
			<th>Expiration Time</th>
			<th>Kilobytes</th>
			<th>Number of files</th>
			<th>Number of copies</th>
			<th>Storage Lifecycle Policy</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Backup ID</th>
			<th>Client</th>
			<th>Policy</th>
			<th>Schedule</th>
			<th>Retention</th>
			<th>Status</th>
			<th>Backup Time</th>
			<th>Elapsed Time</th>
			<th>Expiration Time</th>
			<th>Kilobytes</th>
			<th>Number of files</th>
			<th>Number of copies</th>
			<th>Storage Lifecycle Policy</th>
		</tr>
	</tfoot>
	<tbody>";
	// output data of each row
	while($row = $result->fetch_assoc()) {
		if($row["status"] == "0"){
			$aStatus = "green";}
		else if($row["status"] == "1"){
			$aStatus = 'yellow';}
		elseif($row["status"] >= "2"){
			$aStatus = "orange";}
		echo "<tr>
				<td>" . $row["client_timestamp"]. "</td>
				<td>" . $row["client"]. "</td>
				<td>" . $row["policy"]. "</td>
				<td>" . $row["sched_label"]. "</td>
				<td>" . $row["retention_level"]. "</td>
				<td style='background-color:".$aStatus."'>" . $row["status"]. "</td>
				<td>" . $row["backup_time"]. "</td>
				<td>" . $row["elapsed_time"]. "</td>						
				<td>" . $row["expiration_time"]. "</td>
				<td>" . $row["kilobytes"]. "</td>
				<td>" . $row["number_of_files"]. "</td>
				<td>" . $row["number_of_copies"]. "</td>
				<td>" . $row["storage_lifecycle_policy"]. "</td>";
		echo "</tr>";
	}
	echo "</tbody></table>";
	
} else {
	echo "0 results";
}
}
/**
 * Graficos
 */
function images_graph_consume_total_all_daily() { /* grafico */
	global $result; /*levanto la variable global*/
	if ($result->num_rows > 0) {
	echo '
<script type="text/javascript">
$(window).load(function(){
	(function basic_time(images_graph_consume_total_all_daily) {

	    var
	    d1 = [],
	        start = new Date("2013/01/01 00:00").getTime(),
	        options, graph, i, x, o;
			
			';
	
	while($row = $result->fetch_assoc()) {
		echo 'd1.push([' . $row["date"]. ', ' . $row["gigabytes"]. '])
				';
}		

    echo '    		      
	    options = {
    		showLabels: true,
	        xaxis: {
	            mode: "time",
    			timeFormat: "%d-%b-%y",
		        timeUnit: "second",
	            labelsAngle: 45
	        },
    		yaxis: {
    			title: "Gigabytes"
    		},
	        selection: {
	            mode: "x"
	        },
	        HtmlText: false,
	        title: "Consumo Total Historico de Imagenes de Backup",
    		subtitle: "Datos Historicos diarios"
	    };

	    // Draw graph with default options, overwriting with passed options


	    function drawGraph(opts) {

	        // Clone the options, so the "options" variable always keeps intact.
	        o = Flotr._.extend(Flotr._.clone(options), opts || {});

	        // Return a new graph.
	        return Flotr.draw(
	        images_graph_consume_total_all_daily, [d1], o);
	    }

	    graph = drawGraph();

	    Flotr.EventAdapter.observe(images_graph_consume_total_all_daily, "flotr:select", function(area) {
	        // Draw selected area
	        graph = drawGraph({
	            xaxis: {
	                min: area.x1,
	                max: area.x2,
	                mode: "time",
    				timeFormat: "%d-%b-%y %h:%M",
		            timeUnit: "second",
	                labelsAngle: 45
	            },
	            yaxis: {
	                min: area.y1,
	                max: area.y2,
    				title: "Gigabytes"
	            }
	        });
	    });

	    // When graph is clicked, draw the graph with default area.
	    Flotr.EventAdapter.observe(images_graph_consume_total_all_daily, "flotr:click", function() {
	        graph = drawGraph();
	    });
	})(document.getElementById("images_graph_consume_total_all_daily"));
});

</script>
    		
<div id="images_graph_consume_total_all_daily"></div>
    		
    		
';
    } else {
    	echo "0 results";}
}
function images_graph_consume_total_all_hour() { /* grafico */
	global $result; /*levanto la variable global*/
	if ($result->num_rows > 0) {
		echo '
<script type="text/javascript">
$(window).load(function(){
	(function basic_time(images_graph_consume_total_all_hour) {

	    var
	    d1 = [],
	        start = new Date("2013/01/01 00:00").getTime(),
	        options, graph, i, x, o;
		
			';

		while($row = $result->fetch_assoc()) {
			echo 'd1.push([' . $row["date"]. ', ' . $row["gigabytes"]. '])
				';
		}

		echo '
	    options = {
    		showLabels: true,
	        xaxis: {
	            mode: "time",
    			timeFormat: "%d-%b-%y %h:%M",
		        timeUnit: "second",
	            labelsAngle: 45
	        },
    		yaxis: {
    			title: "Gigabytes"
    		},
	        selection: {
	            mode: "x"
	        },
	        HtmlText: false,
	        title: "Consumo Total Historico de Imagenes de Backup",
    		subtitle: "Datos Historicos diarios"
	    };

	    // Draw graph with default options, overwriting with passed options


	    function drawGraph(opts) {

	        // Clone the options, so the "options" variable always keeps intact.
	        o = Flotr._.extend(Flotr._.clone(options), opts || {});

	        // Return a new graph.
	        return Flotr.draw(
	        images_graph_consume_total_all_hour, [d1], o);
	    }

	    graph = drawGraph();

	    Flotr.EventAdapter.observe(images_graph_consume_total_all_hour, "flotr:select", function(area) {
	        // Draw selected area
	        graph = drawGraph({
	            xaxis: {
	                min: area.x1,
	                max: area.x2,
	                mode: "time",
    				timeFormat: "%d-%b-%y %h",
		            timeUnit: "second",
	                labelsAngle: 45
	            },
	            yaxis: {
	                min: area.y1,
	                max: area.y2,
    				title: "Gigabytes"
	            }
	        });
	    });

	    // When graph is clicked, draw the graph with default area.
	    Flotr.EventAdapter.observe(images_graph_consume_total_all_hour, "flotr:click", function() {
	        graph = drawGraph();
	    });
	})(document.getElementById("images_graph_consume_total_all_hour"));
});

</script>

<div id="images_graph_consume_total_all_hour"></div>


';
	} else {
		echo "0 results";}
}

function images_graph_consume_1d() { /* grafico */
	global $result; /*levanto la variable global*/
	if ($result->num_rows > 0) {
		echo '
<script type="text/javascript">
$(window).load(function(){
	(function basic_time(images_graph_consume_1d) {

	    var
	    d1 = [],
	        start = new Date("2013/01/01 00:00").getTime(),
	        options, graph, i, x, o;

			';

		while($row = $result->fetch_assoc()) {
			echo 'd1.push([' . $row["date"]. ', ' . $row["gigabytes"]. '])
				';
		}

		echo '
	    options = {
    		showLabels: true,
	        xaxis: {
	            mode: "time",
    			timeFormat: "%d-%b-%y %h",
		        timeUnit: "second",
	            labelsAngle: 45
	        },
    		yaxis: {
    			title: "Gigabytes"
    		},
	        selection: {
	            mode: "x"
	        },
	        HtmlText: false,
	        title: "Consumo Diario de Backup",
    		subtitle: "Datos diarios"
	    };

	    // Draw graph with default options, overwriting with passed options


	    function drawGraph(opts) {

	        // Clone the options, so the "options" variable always keeps intact.
	        o = Flotr._.extend(Flotr._.clone(options), opts || {});

	        // Return a new graph.
	        return Flotr.draw(
	        images_graph_consume_1d, [d1], o);
	    }

	    graph = drawGraph();

	    Flotr.EventAdapter.observe(images_graph_consume_1d, "flotr:select", function(area) {
	        // Draw selected area
	        graph = drawGraph({
	            xaxis: {
	                min: area.x1,
	                max: area.x2,
	                mode: "time",
    				timeFormat: "%d-%b-%y %h",
		            timeUnit: "second",
	                labelsAngle: 45
	            },
	            yaxis: {
	                min: area.y1,
	                max: area.y2,
    				title: "Gigabytes"
	            }
	        });
	    });

	    // When graph is clicked, draw the graph with default area.
	    Flotr.EventAdapter.observe(images_graph_consume_1d, "flotr:click", function() {
	        graph = drawGraph();
	    });
	})(document.getElementById("images_graph_consume_1d"));
});

</script>

<div id="images_graph_consume_1d"></div>


';
	} else {
		echo "0 results";}
}


/**
 *  Inicio Formulario 
 */
?>