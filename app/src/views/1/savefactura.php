<?php
	
	$saved = false;

	if($this->getHttpVars()->isSetPost("dataFactura")){
		$dataFactura = json_decode(Wave\TextEncoder::text_decode(
			$this->getHttpVars()->post("dataFactura")
		),true);


		if($this->getDatabase()->Query(sprintf(
			"INSERT INTO factura (fecha,hora,nombre_cliente,subtotal,usuario,empresa) 
										VALUES ('%s','%s','%s','%f','%d','%d') ",
			date("Y-m-d"),date("H:i:s"),$dataFactura['nombre_cliente'],$dataFactura['subtotal'],
			$this->UserData->getId(),$this->UserData->getEmpresa()
		))){
			$idFactura = $this->getDatabase()->getConnect()->insert_id;

			$this->getDatabase()->Query("INSERT INTO detalle_factura (factura,producto,cantidad) VALUES ".getStringProductosInsertSql($dataFactura['lista_compra'],$idFactura));

			$listProductosSQL = "(".getStringProductosIdWhereSql($dataFactura['lista_compra']).")";

			$queryPro = $this->getDatabase()->Query("SELECT id_producto,precio,cantidad_existencia FROM productos WHERE id_producto IN ".$listProductosSQL);

			while ($producto = $this->getDatabase()->FetchArray($queryPro)) {
				$cantidad_existencia_new = ((int)$producto['cantidad_existencia']) - getCantidadProducto($dataFactura['lista_compra'],$producto['id_producto']);
				$this->getDatabase()->Query(sprintf("UPDATE productos SET cantidad_existencia = '%d'",$cantidad_existencia_new));
			}
			$saved = true;
		}
	}

	echo json_encode(array(
		'SAVED':$saved,
	));

	function getStringProductosIdWhereSql($datos){
		$string = "";
		for ($i=1; $i < count($datos); $i++) { 
			$string .= ",".$datos[$i]['id'];
		}
		return $datos[0]['id'].$string;
	}

	function getStringProductosInsertSql($datos,$factura){
		$string = "";
		for ($i=1; $i < count($datos); $i++) { 
			$string .= ",(".$factura.",".$datos[$i]['id'].",".$datos[$i]['cantidad'].")";
		}
		return "(".$factura.",".$datos[0]['id'].",".$datos[0]['cantidad'].")".$string;
	}

	function getCantidadProducto($datos,$id){
		for ($i=0; $i < count($datos); $i++) { 
			if($datos[$i]["id"]==$id){
				return (int)$datos[$i]["cantidad"];
			}
		}
		return 0;
	}

?>