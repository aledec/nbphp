<?php
/*
 * 
 * Variables Super Globales
 * 
 */

/*
 * 
 * Funciones de diseño de js añadidos
 * 
 */
function style_menu(){ /*estilo de menu por defecto */
	echo '
	<link rel="stylesheet" href="css/slimmenu/style.css" type="text/css">
    <link rel="stylesheet" href="css/slimmenu/slimmenu.css" type="text/css">
    <style>
        body {
            font-family: "Lucida Sans Unicode", "Lucida Console", sans-serif;
            padding: 0;
        }
        a, a:active { text-decoration: none }
    </style>
    <script src="libs/jquery/jquery-1.11.3.min.js"></script>
    <script src="libs/slimmenu/jquery.slimmenu.js"></script>
    <script src="libs/slimmenu/jquery.easing.min.js"></script>';
}
function style_table() { /*estilo de tabla por defecto */
	echo '
		<link rel="stylesheet" href="css/jquery/jquery-ui.css" type="text/css">
		<link rel="stylesheet" href="css/datatables/dataTables.jqueryui.min.css" type="text/css">
		<link rel="stylesheet" href="css/datatables/buttons.jqueryui.min.css" type="text/css">

		<script type="text/javascript" src="libs/datatables/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="libs/datatables/dataTables.jqueryui.min.js"></script>
		<script type="text/javascript" src="libs/datatables/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="libs/datatables/buttons.jqueryui.min.js"></script>
		<script type="text/javascript" src="libs/datatables/jszip.min.js"></script>
		<script type="text/javascript" src="libs/datatables/pdfmake.min.js"></script>
		<script type="text/javascript" src="libs/datatables/vfs_fonts.js"></script>
		<script type="text/javascript" src="libs/datatables/buttons.html5.min.js"></script>
		<script type="text/javascript" src="libs/datatables/buttons.print.min.js"></script>
		
		<script class="init" type="text/javascript">
                $(document).ready(function() {
				    var table = $("#tb").DataTable( {
    		            "scrollX": true,
                        "stateSave": true,
                        "pagingType": "full_numbers",
			        	"lengthChange": false,
						select: {
				            style: "single"
				        },
						"buttons": [
									{
										extend: "copyHtml5",
										text: "Copiar"
									},
			    	        "excelHtml5",
				            "csvHtml5",
				            "pdfHtml5",
							        {
							            extend: "print",
							            text: "Imprimir",
							            autoPrint: false
							        },
						],
                        "language": {
						    "emptyTable":     "No se han encontrado datos en la tabla",
						    "info": "Mostrando pagina _PAGE_ de _PAGES_",
									    "infoEmpty":      "No se han encontrado registros",
						    "infoFiltered":   "(Filtrados de _MAX_ total registros)",
						    "infoPostFix":    "",
						    "thousands":      ",",
						    "lengthMenu":     "Mostrar _MENU_ registros por pagina",
						    "loadingRecords": "Cargando...",
						    "processing":     "Procesando...",
						    "search":         "Buscar:",
						    "zeroRecords":    "No se han encontrado registros",
						    "paginate": {
						        "first":      "Primera",
						        "last":       "Ultima",
						        "next":       "Proxima",
						        "previous":   "anterior"
						    },
						    "aria": {
						        "sortAscending":  ": activar para ordenar de forma ascendente",
						        "sortDescending": ": activar para ordenar de forma descendente"
						    }
						}
                    } );
				    table.buttons().container()
				        .insertBefore( "#tb_filter" );

		       } );
</script>';
}
function style_dashboard(){  /*estilo de menu del dashboard */
	
echo '
	<link type="text/css" href="css/jquery/jquery-ui.css" rel="stylesheet">
	<link type="text/css" href="css/sdashboard/sDashboard.css" rel="stylesheet">
	
		<script src="libs/jquery/jquery-1.8.3.js" type="text/javascript"> </script>
		<script src="libs/jquery/jquery-ui.js" type="text/javascript"> </script>
		<script src="libs/datatables/jquery.dataTables.js"> </script>
	
		<!--[if IE]>
		<script language="javascript" type="text/javascript" src="libs/flotr2/flotr2.ie.min.js"></script>
		<![endif]-->
		<script src="libs/flotr2/flotr2.js" type="text/javascript"> </script>
		<script src="libs/sdashboard/jquery-sDashboard.js" type="text/javascript"> </script>
		<script src="libs/themeswitcher/jquery.themeswitcher.min.js" type="text/javascript"> </script>		
		';
}
function style_graph(){ /* estilo de graficos por defecto */
	echo '
	<link rel="stylesheet" href="css/flotr2/flotr2.css" type="text/css">
    <script type="text/javascript" src="libs/flotr2/flotr2.js"></script>
    <script type="text/javascript" src="libs/canvas/flashcanvas.js"></script>
';
}

/*
 * 
 * Funciones de diseño del sitio
 *
 */	
function menudashboard() {
	echo '<ul class="slimmenu">
		<li>
			<a href="index.php">Inicio</a>
		</li>
		<li>
			<a href="dashboard.php">Dashboard Global</a>
		</li>
		<li>
			<a href="dashboard-win.php">Windows</a>
		</li>
		<li>
			<a href="dashboard-sap.php">SAP</a>
		</li>
		<li>
			<a href="dashboard-unix.php">UNIX</a>
		</li>
		<li>
			<a href="dashboard-vmware.php">VMWARE</a>
		</li>
		<li>
			<a href="dashboard-others.php">Estaticos</a>
		</li>
	</ul>';
}
function menu() { /* menu desplegable */
echo '
<ul class="slimmenu">
    <li>
        <a href="index.php">Inicio</a>
    </li>
    <li>
        <a href="dashboard.php">Dashboard</a>
    </li>
    <li>
        <a href="#">Clientes</a>
        <ul>
            <li><a href="index.php?oper=clientname&tx=table&pfunction=client_view">Listado</a></li>
			<li><a href="#">Tipo</a>
				<ul>
			            <li><a href="index.php?oper=clientname&tx=table&pos=aix">AIX</a></li>
		            	<li><a href="index.php?oper=clientname&tx=table&pos=virtual">Virtual</a></li>
						<li><a href="index.php?oper=clientname&tx=table&pos=win">Windows</a></li>
						<li><a href="index.php?oper=clientname&tx=table&pos=hp">HP-UX</a></li>
				</ul>
			</li>	
			<li><a href="#">Graficos</a>
				<ul>
			            <li><a href="index.php?oper=clientname&tx=graph_clientOsLike">% Clientes</a></li>
				</ul>
			</li>
        </ul>
    </li>
    <li><a href="#">Politicas</a>
	        <ul>
	            <li><a href="index.php?oper=policy&tx=table">Listado</a>
					<ul>
			            <li><a href="index.php?oper=policy&tx=table&pactive=yes">Listado Activas</a></li>
		            	<li><a href="index.php?oper=policy&tx=table&pactive=no">Listado Inactivas</a></li>  
					</ul>
				</li>
			    <li><a href="#">Hosts</a>
					<ul>
			            <li><a href="index.php?oper=policy&tx=table&pclientname=ssj">WIN32</a></li>
		            	<li><a href="index.php?oper=policy&tx=table&pclientname=sap">SAP</a></li>
					</ul>
				</li>
				<li><a href="#">Tipo</a>
					<ul>
			            <li><a href="index.php?oper=policy&tx=table&ptype=oracle">Oracle</a></li>
		            	<li><a href="index.php?oper=policy&tx=table&ptype=sap">SAP</a></li>
						<li><a href="index.php?oper=policy&tx=table&ptype=sql">SQL</a></li>
						<li><a href="index.php?oper=policy&tx=table&ptype=MS">Microsoft</a></li>
						<li><a href="index.php?oper=policy&tx=table&ptype=vmware">VMWARE</a></li>
						<li><a href="index.php?oper=policy&tx=table&ptype=standard">Standard</a></li>
					</ul>
				</li>
				<li><a href="#">Graficos</a>
					<ul>
				            <li><a href="index.php?oper=policy&tx=graph_PolicyTypeLike">Types (%)</a></li>
				            <li><a href="index.php?oper=policy&tx=graph_PolicyActive">Active (%)</a></li>
		
					</ul>
				</li>
			</ul>
	</li>
    <li><a href="#">Reportes</a>
        <ul>
            <!--<li><a href="#">Backups fallidos</a>
                <ul>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=24&pnstatus=1">24 Horas</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=48&pnstatus=1">48 Horas</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=72&pnstatus=1">72 Horas</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=168&pnstatus=1">07 Dias</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=720&pnstatus=1">30 Dias</a></li>
                </ul>
            </li>-->
            <li><a href="#">Backups</a>
                <ul>
		            <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=12">12 Horas</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=24">24 Horas</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=48">48 Horas</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=72">72 Horas</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=168">07 Dias</a></li>
                    <li><a href="index.php?oper=images&tx=table&pfunction=images_view&ptimeago=720">30 Dias</a></li>
                </ul>
            </li>		
            <li><a href="#">Especiales</a>
                <ul>
                    <li><a href="#">Mayor Tiempo</a>
						<ul>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_time&ptimeago=24&plimit=10">24 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_time&ptimeago=48&plimit=20">48 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_time&ptimeago=72&plimit=30">72 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_time&ptimeago=168&plimit=70">07 Dias</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_time&ptimeago=720&plimit=300">30 Dias</a></li>
						</ul>
					</li>
                    <li><a href="#">Mayor Kilobytes</a>
						<ul>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_kb&ptimeago=24&plimit=10">24 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_kb&ptimeago=48&plimit=20">48 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_kb&ptimeago=72&plimit=30">72 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_kb&ptimeago=168&plimit=70">07 Dias</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_kb&ptimeago=720&plimit=300">30 Dias</a></li>
						</ul>
					</li>
                    <li><a href="#">Mayor Promedio</a>
						<ul>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_prom&ptimeago=24&plimit=10">24 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_prom&ptimeago=48&plimit=20">48 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_prom&ptimeago=72&plimit=30">72 Horas</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_prom&ptimeago=168&plimit=70">07 Dias</a></li>
		                    <li><a href="index.php?oper=images&tx=table&pfunction=images_prom&ptimeago=720&plimit=300">30 Dias</a></li>
						</ul>
					</li>
                </ul>
            </li>
		<li><a href="#">Graficos</a>
			<ul>
				<li><a href="?oper=images&tx=graph_consume_all_daily">Consumo historico por dia</a></li>
				<li><a href="?oper=images&tx=graph_consume_all_hour">Consumo historico por hora</a></li>
				<li><a href="?oper=images&tx=graph_consume_1d">Consumo ultimas 24 horas</a></li>
			</ul>
		
		</li> 
		</ul>
    </li>
    <li><a href="#">Errores</a>
        <ul>
            <li><a href="#">Listado Errores</a>
                <ul>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=12&pnstatus=1">12 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=24&pnstatus=1">24 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=48&pnstatus=1">48 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=72&pnstatus=1">72 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=168&pnstatus=1">7 Dias</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=720&pnstatus=1">30 Dias</a></li>
                </ul>
            </li>
		    <li><a href="#">Listado Backups</a>
                <ul>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=12">12 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=24">24 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=48">48 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=72">72 Horas</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=168">7 Dias</a></li>
                    <li><a href="index.php?oper=errors&tx=table&pfunction=errors_view&ptimeago=720">30 Dias</a></li>
                </ul>
            </li>
        </ul>
	</li>
	<!-- <li><a href="#">Graficos</a>
        <ul>
            <li><a href="#">Solicitud de Reporte</a></li>
            <li><a href="#">Listado de Reportes</a></li>
        </ul>    
 	</li>
    <li><a href="#">Otros</a>
        <ul>
            <li><a href="#">Configuracion correo Reporte</a></li>
            <li><a href="#">Configuracion export PDF</a></li>
        </ul>    
 	</li> -->
</ul>

<script>
$("ul.slimmenu").slimmenu(
{
    resizeWidth: "800",
    collapserTitle: "Main Menu",
    easingEffect:"easeInOutQuint",
    animSpeed:"medium",
    indentChildren: true,
    childrenIndenter: "&raquo;"
});
</script>';
}

function onloadDashboard() {
	echo '<script type="text/javascript">
$(document).ready(function() {
	
	$(".slimmenu").show();
	$(".headNote").show();
	$("#myDashboard").show();
	$(".footer").show();
	$(".spinner").hide();
});
</script>
';
}
function loadWait() {
	echo '<div class="spinner">
	<img src="css/images/gif-load.gif" alt="Loading" />
	</div>';
}
/*
 * 
 * Funciones para simplificar codigo del diseño del sitio
 * 
 */
function starthead(){ /* abro el documento */
	echo '<!DOCTYPE html>
		<html>
		<head>
			'; 
}
function endhead(){  /* abro el body */
	echo '</head>
		<body>';
	
}
function footer(){ /*dibujo pie de pagina, con todas sus opciones*/
	echo '
	<div id="footer" class="footer">
	<p><!--[if lte IE 8]><span style="filter: FlipH; -ms-filter: "FlipH"; display: inline-block;"><![endif]--><span style="-moz-transform: scaleX(-1); -o-transform: scaleX(-1); -webkit-transform: scaleX(-1); transform: scaleX(-1); display: inline-block;">&copy;</span><!--[if lte IE 8]></span><![endif]--> CopyLeft <a href="http://aledec.com.ar"><abbr>@_aledec</abbr></a>, All Wrongs Reversed, <script type="text/javascript">var d = new Date(); var year = d.getFullYear(); document.write(year);</script>.</p>
	</div>
</body>
</html>';
};




/*
 * 
 * 
 * 
 */


?>