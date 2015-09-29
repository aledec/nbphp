<?php 
require_once 'src/func.php'; /*incluyo funciones */
starthead(); /*incluyo el header de la pagina*/

/**
 *  Inicio Formulario
 */
if (isset($_GET['oper']) && isset($_GET['tx'])) {
	switch ($_GET['oper']){
		case "clientname": /* en caso que se requiera la opcion clientname */
			require_once 'src/clientname.php'; /* incluyo funciones para busquedas de clientname */
			switch ($_GET['tx']) { /* transaccion */
				case "table": /* en caso requerir mostrar una tabla */
					style_menu(); /*estilo de menu por defecto */
					style_table(); /* estilo de tabla por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					$c = new clientname_table_nb();
						$c->clientname_table_nb__params();
						$c->clientname_table_nb__data();
						$c->clientname_table_nb__table();
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				case "graph_clientOsLike": /* en caso requerir mostrar grafico */
					style_menu(); /*estilo de menu por defecto */
					style_graph(); /* estilo de graficos por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					$c = new clientname_oslike_nb();
						$c->clientname_oslike_nb__data();
						$c->clientname_oslike_nb__draw();
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				default: /* opcion no valida */
					style_menu(); /*estilo de menu por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */ 
					echo "No se ha seleccionado una opcion valida para tx";	
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
			}
			break;
		case "policy": /* en caso que se requiera la opcion policies */
			require_once 'src/policy.php'; /* incluyo funciones para busquedas de policies */
			switch ($_GET['tx']) { /* transaccion */
				case "table": /* en caso requerir mostrar una tabla */
					style_menu(); /*estilo de menu por defecto */
					style_table(); /* estilo de tabla por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					$p = new policy_table_nb();
						$p->policy_table_nb__params();
						$p->policy_table_nb__data();
						$p->policy_table_nb__table();
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				case "graph_PolicyTypeLike": /* en caso requerir mostrar grafico */
					style_menu(); /*estilo de menu por defecto */
					style_graph(); /* estilo de graficos por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					$p = new policy_type_like_nb();
						$p->policy_type_like_nb__data();
						$p->policy_type_like_nb__draw();
					policy_graph_type_like(); /* valores para grafico */
					policy_draw_type_like(); /* grafico */
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				case "graph_PolicyActive":
					style_menu(); /*estilo de menu por defecto */
					style_graph(); /* estilo de graficos por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					$p = new policy_active_nb();
						$p->policy_data_active();
						$p->policy_draw_active();
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				default: /* opcion no valida */
					style_menu(); /*estilo de menu por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					echo "No se ha seleccionado una opcion valida para tx";
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
			}
			break;
		case "images": /* en caso que se requiera la opcion policies */
			include 'src/images.php'; /* incluyo funciones para busquedas de images */
			switch ($_GET['tx']) { /* transaccion */
				case "table": /* en caso requerir mostrar una tabla */
					style_menu(); /*estilo de menu por defecto */
					style_table(); /* estilo de tabla por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					images_params(); /* utilizada unicamente para remplazar los parametros enviados*/
					images_query_view(); /*coneccion sql*/
					images_table(); /*dibujo tabla*/
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				default: /* opcion no valida */
					style_menu(); /*estilo de menu por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					echo "No se ha seleccionado una opcion valida para tx";
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				case "graph_consume_7D": /* en caso requerir mostrar grafico */
					style_menu(); /*estilo de menu por defecto */
					style_graph(); /* estilo de graficos por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					images_query_graph_consume_7d();
					images_graph_consume_7d(); /* grafico */
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				case "graph_consume_all_daily": /* en caso requerir mostrar grafico */
					style_menu(); /*estilo de menu por defecto */
					style_graph(); /* estilo de graficos por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					images_query_graph_consume_total_all_daily();
					images_graph_consume_total_all_daily(); /* grafico */
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				case "graph_consume_all_hour": /* en caso requerir mostrar grafico */
					style_menu(); /*estilo de menu por defecto */
					style_graph(); /* estilo de graficos por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					images_query_graph_consume_total_all_hour();
					images_graph_consume_total_all_hour(); /* grafico */
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				case "graph_consume_1d":
					style_menu(); /*estilo de menu por defecto */
					style_graph(); /* estilo de graficos por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					images_query_graph_consume_1d();
					images_graph_consume_1d(); /* grafico */
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
			}
			break;
		case "errors": /* en caso que se requiera la opcion clientname */
			include 'src/errors.php'; /* incluyo funciones para busquedas de clientname */
			switch ($_GET['tx']) { /* transaccion */
				case "table": /* en caso requerir mostrar una tabla */
					style_menu(); /*estilo de menu por defecto */
					style_table(); /* estilo de tabla por defecto */
					endhead(); /* abro el body */
					menu(); /* menu desplegable */
					$e = new errors_table_nb();
						$e->errors_table_nb__params();
						$e->errors_table_nb__data();
						$e->errors_table_nb__table();
					footer(); /*dibujo pie de pagina, con todas sus opciones*/
					break;
				}
				break;
		default: /* opcion no valida */
			style_menu(); /*estilo de menu por defecto */
			endhead(); /* abro el body */
			menu(); /* menu desplegable */
			echo "No se ha seleccionado una opcion valida para oper";	
			footer(); /*dibujo pie de pagina, con todas sus opciones*/
			break;
		}
}
else{
	style_menu(); /*estilo de menu por defecto */
	endhead(); /* abro el body */
	menu(); /* menu desplegable */
	echo "Seleccione una opcion (*)";	
	footer(); /*dibujo pie de pagina, con todas sus opciones*/
}
?>