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
	Los siguientes graficos aplican unicamente a ambientes VMWARE. En caso que el dato buscado no se encuentre o sea insuficiente se sugiere utilizar la función especifica fuera del dashboard.
</ul>
<ul id="myDashboard" class="myDashboard"></ul>

<?php 
	$i=new images_ConsumeHistoricAllDaily();
	$params=array('name' => 'images_ConsumeHistoricAllDaily_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 'type' => 'hour',4);
		$i->images_ConsumeHistoricAllDaily__params($params);
		$i->images_ConsumeHistoricAllDaily__data($params);
		$i->images_ConsumeHistoricAllDaily__js($params);
	$params=array('name' => 'images_ConsumeHistoricAllDaily_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 'type' => 'day',4);
		$i->images_ConsumeHistoricAllDaily__params($params);
		$i->images_ConsumeHistoricAllDaily__data($params);
		$i->images_ConsumeHistoricAllDaily__js($params);
	$params=array('name' => 'images_ConsumeHistoricAllDaily_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 'type' => 'day',4);
		$i->images_ConsumeHistoricAllDaily__params($params);
		$i->images_ConsumeHistoricAllDaily__data($params);
		$i->images_ConsumeHistoricAllDaily__js($params);
?>
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
					$p = new policy_active_ds();  //dashboard policy active/inactive
						$params=array('name' => 'policy_active_ds', 'policy' => 'vmware', 2);
						$p->policy_active_ds__data($params);
						$p->policy_active_ds__draw($params);
					?>
				}, {
					<?php
					$e = new errors_StatusLike_ds; // % of return status like code - multiple params possible
						$params=array('name' => 'errors_statuslike_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$e->errors_StatusLike_ds__data($params);
						$e->errors_StatusLike_ds__graph($params);
					?>
				}, {
					<?php
					$e = new errors_StatusLike_ds; // % of return status like code - multiple params possible
						$params=array('name' => 'errors_StatusLike_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$e->errors_StatusLike_ds__data($params);
						$e->errors_StatusLike_ds__graph($params);
					?>
				}, {
					<?php
					$e = new errors_StatusLike_ds; // % of return status like code - multiple params possible
						$params=array('name' => 'errors_StatusLike_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$e->errors_StatusLike_ds__data($params);
						$e->errors_StatusLike_ds__graph($params);
					?>
				}, {
					<?php 
					$e = new errors_StatusLikeDefined_ds(); // % of return status like code not 0 - multiple params possible
						$params=array('name' => 'errors_StatusLikeDefined_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$e->errors_StatusLikeDefined_ds__data($params);
						$e->errors_StatusLikeDefined_ds__graph($params);
					?>
				}, {
					<?php 
					$e = new errors_StatusLikeDefined_ds(); // % of return status like code not 0 - multiple params possible
						$params=array('name' => 'errors_StatusLikeDefined_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$e->errors_StatusLikeDefined_ds__data($params);
						$e->errors_StatusLikeDefined_ds__graph($params);
					?>
				}, {
					<?php 
					$e = new errors_StatusLikeDefined_ds(); // % of return status like code not 0 - multiple params possible
						$params=array('name' => 'errors_StatusLikeDefined_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$e->errors_StatusLikeDefined_ds__data($params);
						$e->errors_StatusLikeDefined_ds__graph($params);
					?>
				}, {	
					<?php 
					$e = new errors_FailedList_ds(); // List of return status not 0 - multiple params possible
						$params=array('name' => 'errors_FailedList_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$e->errors_FailedList_ds__data($params);
						$e->errors_FailedList_ds__table($params);
					?>
				}, {
					<?php 
					$e = new errors_FailedList_ds(); // List of return status not 0 - multiple params possible
						$params=array('name' => 'errors_FailedList_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$e->errors_FailedList_ds__data($params);
						$e->errors_FailedList_ds__table($params);
					?>
				}, {
					<?php 
					$e = new errors_FailedList_ds(); // List of return status not 0 - multiple params possible
						$params=array('name' => 'errors_FailedList_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$e->errors_FailedList_ds__data($params);
						$e->errors_FailedList_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_RetentionLevelList_ds(); // List of retention level - multiple params possible
						$params=array('name' => 'images_RetentionLevelList_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$i->images_RetentionLevelList_ds__data($params);
						$i->images_RetentionLevelList_ds__graph($params);
					?>
				}, {
					<?php 
					$i = new images_RetentionLevelList_ds(); // List of retention level - multiple params possible
						$params=array('name' => 'images_RetentionLevelList_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$i->images_RetentionLevelList_ds__data($params);
						$i->images_RetentionLevelList_ds__graph($params);
					?>
				}, {
					<?php 
					$i = new images_RetentionLevelList_ds(); // List of retention level - multiple params possible
						$params=array('name' => 'images_RetentionLevelList_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$i->images_RetentionLevelList_ds__data($params);
						$i->images_RetentionLevelList_ds__graph($params);
					?>
				}, {
					<?php 
					$i = new images_ClientImageInImages_ds(); //List of clients in images - multiple params possible
						$params=array('name' => 'images_ClientImageInImages_ds_24h', 'client' => 'vmware', 'timeago' => '24 Hour', 3);
						$i->images_ClientImageInImages_ds__data($params);
						$i->images_ClientImageInImages_ds__graph($params);
					?>
				}, {
					<?php 
					$i = new images_ConsumeClientList_ds(); //List consume of clients - multiple params possible
						$params=array('name' => 'images_ConsumeClientList_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$i->images_ConsumeClientList_ds__data($params);
						$i->images_ConsumeClientList_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_ConsumeClientList_ds(); //List consume of clients - multiple params possible
						$params=array('name' => 'images_ConsumeClientList_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$i->images_ConsumeClientList_ds__data($params);
						$i->images_ConsumeClientList_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_ConsumeClientList_ds(); //List consume of clients - multiple params possible
						$params=array('name' => 'images_ConsumeClientList_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$i->images_ConsumeClientList_ds__data($params);
						$i->images_ConsumeClientList_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_ConsumePolicyList_ds();
						$params=array('name' => 'images_ConsumePolicyList_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$i->images_ConsumePolicyList_ds__data($params);
						$i->images_ConsumePolicyList_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_ConsumePolicyList_ds();
						$params=array('name' => 'images_ConsumePolicyList_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$i->images_ConsumePolicyList_ds__data($params);
						$i->images_ConsumePolicyList_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_ConsumePolicyList_ds();
						$params=array('name' => 'images_ConsumePolicyList_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$i->images_ConsumePolicyList_ds__data($params);
						$i->images_ConsumePolicyList_ds__table($params);
					?>
				}, {
					<?php
					$i = new images_ListGroupHour_ds();
						$params=array('name' => 'images_ListGroupHour_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$i->images_ListGroupHour_ds__data($params);
						$i->images_ListGroupHour_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_ListGroupHour_ds();
						$params=array('name' => 'images_ListGroupHour_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$i->images_ListGroupHour_ds__data($params);
						$i->images_ListGroupHour_ds__table($params);
					?>
				}, {
					<?php 
					$i = new images_ListGroupHour_ds();
						$params=array('name' => 'images_ListGroupHour_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$i->images_ListGroupHour_ds__data($params);
						$i->images_ListGroupHour_ds__table($params);
					?>
				}, {
					<?php
					$i = new images_PolicyLikeList_ds(); //List consume by Policy like pie - multiple params possible
						$params=array('name' => 'images_PolicyLikeList_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 3);
						$i->images_ClientLikeList_ds__data($params);
						$i->images_ClientLikeList_ds__graph($params);
					?>
				}, {
					<?php
					$i = new images_PolicyLikeList_ds(); //List consume by Policy like pie - multiple params possible
						$params=array('name' => 'images_PolicyLikeList_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 3);
						$i->images_ClientLikeList_ds__data($params);
						$i->images_ClientLikeList_ds__graph($params);
					?>
				}, {
					<?php
					$i = new images_PolicyLikeList_ds(); //List consume by Policy like pie - multiple params possible
						$params=array('name' => 'images_PolicyLikeList_ds_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 3);
						$i->images_ClientLikeList_ds__data($params);
						$i->images_ClientLikeList_ds__graph($params);
					?>
				}, {
					<?php 		
					$i=new images_ConsumeHistoricAllDaily(); //List historic consume chart browse - multiple params possible
						$params=array('name' => 'images_ConsumeHistoricAllDaily_24h', 'policy' => 'vmware', 'timeago' => '24 Hour', 'type' => 'hour',4);
						$i->images_ConsumeHistoricAllDaily__params($params);
						$i->images_ConsumeHistoricAllDaily__graph($params);
					?>
				}, {
					<?php 		
					$i=new images_ConsumeHistoricAllDaily(); //List historic consume chart browse - multiple params possible
						$params=array('name' => 'images_ConsumeHistoricAllDaily_7d', 'policy' => 'vmware', 'timeago' => '7 Day', 'type' => 'day',4);
						$i->images_ConsumeHistoricAllDaily__params($params);
						$i->images_ConsumeHistoricAllDaily__graph($params);
					?>
				}, {
					<?php 		
					$i=new images_ConsumeHistoricAllDaily(); //List historic consume chart browse - multiple params possible
						$params=array('name' => 'images_ConsumeHistoricAllDaily_14d', 'policy' => 'vmware', 'timeago' => '14 Day', 'type' => 'day',4);
						$i->images_ConsumeHistoricAllDaily__params($params);
						$i->images_ConsumeHistoricAllDaily__graph($params);
					?>
				}, {
					<?php 
					$i=new images_PolicyListInImages_ds();
						$params=array('name' => 'images_PolicyListInImages_ds_24h', 'policy' => 'vmware', 'timeago' => '24 Hour',3);
						$i->images_PolicyListInImages_ds__data($params);
						$i->images_PolicyListInImages_ds__graph($params);
					?>
				}, {
					<?php 
					$i=new images_PolicyListInImages_ds();
						$params=array('name' => 'images_PolicyListInImages_ds_7d', 'policy' => 'vmware', 'timeago' => '7 Day',3);
						$i->images_PolicyListInImages_ds__data($params);
						$i->images_PolicyListInImages_ds__graph($params);
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