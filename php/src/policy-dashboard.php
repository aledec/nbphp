<?php

class policy_active_ds { //dashboard policy active/inactive
	public $result_policy_active_yes = '0'; 		/* YES */
	public $result_policy_active_no = '0';			/* NO */
	
	function policy_active_ds__data($params) { /* valores para grafico */
		require 'config-db.php';
		if ($params['policy'] == 'Any') {
			$sql = 'SELECT COUNT(*) as total FROM `policies` WHERE `active` LIKE "%yes%"';
				$result = $conn->query($sql);
				$this->result_policy_active_yes = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `policies` WHERE `active` LIKE "%no%"';
				$result = $conn->query($sql);
				$this->result_policy_active_no = $result->fetch_assoc();
		}
		else {
			$sql = 'SELECT COUNT(*) as total FROM `policies` WHERE `active` LIKE "%yes%"
					AND `name` LIKE "%'.$params['policy'].'%"';
				$result = $conn->query($sql);
				$this->result_policy_active_yes = $result->fetch_assoc();
			$sql = 'SELECT COUNT(*) as total FROM `policies` WHERE `active` LIKE "%no%"
					AND `name` LIKE "%'.$params['policy'].'%"';
				$result = $conn->query($sql);
				$this->result_policy_active_no = $result->fetch_assoc();
		}
	}

	function policy_active_ds__draw($params) {
		echo '
			widgetTitle : "Porcentaje de Politicas Activas - '."$params[policy]".'",
			widgetId : "'."$params[name]".'",
			widgetType : "chart",
			widgetContent : {
			data : [
			{
			data : [[0, ' .$this->result_policy_active_yes["total"]. ']],
			label: "Activas"
		},{
			data : [[0, ' .$this->result_policy_active_no["total"]. ']],
			label: "Inactivas"
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

class policy_type_like_ds{ //Policy Type Defined
	public $result_policy_type_like_oracle;/* ORACLE */
	public $result_policy_type_like_sap;/* SAP */
	public $result_policy_type_like_sql;/* SQL */
	public $result_policy_type_like_ms;/* MS */
	public $result_policy_type_like_vmware;/* VMWARE */
	public $result_policy_type_like_standard;/* STANDARD */
	public $result_policy_type_like_others;/* OTHERS */
	
	function policy_type_like_ds__data() {
		require 'config-db.php';
		
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%oracle%'";
			$result = $conn->query($sql);
			$this->result_policy_type_like_oracle = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%sap%'";
			$result = $conn->query($sql);
			$this->result_policy_type_like_sap = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%sql%'";
			$result = $conn->query($sql);
			$this->result_policy_type_like_sql = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%ms%'";
			$result = $conn->query($sql);
			$this->result_policy_type_like_ms = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%vmware%'";
			$result = $conn->query($sql);
			$this->result_policy_type_like_vmware = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` LIKE '%standard%'";
			$result = $conn->query($sql);
			$this->result_policy_type_like_standard = $result->fetch_assoc();
		$sql = "SELECT COUNT(*) as total FROM `policies` WHERE `type` NOT LIKE '%oracle%'
		 			AND `type` NOT LIKE '%sap%' AND `type` NOT LIKE '%sql%'
		 			AND `type` NOT LIKE '%ms%'  AND `type` NOT LIKE '%vmware%'
					AND `type` NOT LIKE '%standard%'";
			$result = $conn->query($sql);
			$this->result_policy_type_like_others = $result->fetch_assoc();
	}
	
	function policy_type_like_ds__draw() {
		echo '
				widgetTitle : "Porcentajes de Politica",
				widgetId : "policy_data_type_like",
				widgetType : "chart",
				widgetContent : {
				data : [
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

?>