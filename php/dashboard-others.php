<?php 
$start = microtime(true);
require_once 'src/func.php'; /*incluyo funciones */
require_once 'src/widget.php'; /* funciones especificas para widgets */
require_once 'src/clientname-dashboard.php'; /* funciones para manejo de clientname */
require_once 'src/policy-dashboard.php'; /* funciones para manejo de policies */
require_once 'src/images-dashboard.php';/* funciones para manejo de imagenes */
require_once 'src/errors-dashboard.php'; /* funciones para manejo de bperror */
starthead(); /*incluyo el header de la pagina*/
style_menu();
style_dashboard(); /*estilo de menu del dashboard */
onloadDashboard();
endhead();
loadWait();
menudashboard();
?>
<ul class="headNote">
	Los siguientes datos se han separado del sistema debido que al ser estaticos requieren una capacidad de procesamiento innecesaria en cada refresh.
</ul>
<ul id="myDashboard"></ul>

		<script type="text/javascript">
			$(function() {
				//Theme switcher plugin
				$("#switcher").themeswitcher({
					imgpath : "css/images/",
					loadTheme : "blitzer"
				});

				//**********************************************//
				//dashboard json data
				//this is the data format that the dashboard framework expects
				//**********************************************//

				var dashboardJSON = [{
					<?php 
					$c = new clientname_table_ds();
						$c->clientname_table_ds__data();
						$c->clientname_table_ds__table();
					?>
				}, {
					<?php
					$c = new clientname_oslike_ds();
						$c->clientname_oslike_ds__data();
						$c->clientname_graph_os_ds__draw();
					?>
				}, {	
					<?php 
					$p = new policy_active_ds();  //dashboard policy active/inactive
						$params=array('name' => 'policy_active_ds', 'policy' => 'Any', 2);
						$p->policy_active_ds__data($params);
						$p->policy_active_ds__draw($params);
					?>
				}, {
					<?php 
					$p = new policy_type_like_ds(); //Policy Type Defined
						$p->policy_type_like_ds__data();
 						$p->policy_type_like_ds__draw();
					?>
				}];

				//basic initialization example
				$("#myDashboard").sDashboard({
					dashboardData : dashboardJSON,
				    disableSelection : false // enables text selection on the dashboard     
					
				});

				//table row clicked event example
				$("#myDashboard").bind("sdashboardrowclicked", function(e, data) {
					$.gritter.add({
						position: 'bottom-left',
						title : 'Table Clic',
						time : 1000,
						text : 'Las opciones de click en modo widget table no se encuentran disponibles'
					});

					if (console) {
						console.log("table row clicked, for widget: " + data.selectedWidgetId);
					}
				});

				//plot selected event example
				$("#myDashboard").bind("sdashboardplotselected", function(e, data) {
					$.gritter.add({
						position: 'bottom-left',
						title : 'Seleccion Plot',
						time : 1000,
						text : 'Las opciones de seleccion en modo widget plot no se encuentran disponibles'
					});
					if (console) {
						console.log("chart range selected, for widget: " + data.selectedWidgetId);
					}
				});
				//plot click event example
				$("#myDashboard").bind("sdashboardplotclicked", function(e, data) {
					$.gritter.add({
						position: 'bottom-left',
						title : 'Clic Plot',
						time : 1000,
						text : 'Las opciones de click en modo widget plot no se encuentran disponibles'
					});
					if (console) {
						console.log("chart clicked, for widget: " + data.selectedWidgetId);
					}
				});

				//widget order changes event example
				$("#myDashboard").bind("sdashboardorderchanged", function(e, data) {
					$.gritter.add({
						position: 'bottom-left',
						title : 'Orden Widget',
						time : 4000,
						text : 'Se ha cambiado el orden de los widgets. Revisar console.log para mas informacion'
					});
					if (console) {
						console.log("Sorted Array");
						console.log("+++++++++++++++++++++++++");
						console.log(data.sortedDefinitions);
						console.log("+++++++++++++++++++++++++");
					}
					
				});

			});
		</script>
<?php 
	footer();
	$end = microtime(true);
	print "<div id='footer' class='footer'>Page generated in ".round(($end - $start), 4)." seconds</div>";
?>