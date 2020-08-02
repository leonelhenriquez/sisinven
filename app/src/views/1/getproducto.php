<?php
	$existe = false;
	if($this->getHttpVars()->isSetPost("id") && ((int)$this->getHttpVars()->post("id"))>0){
		if(
			$query_producto = $this->getDatabase()->Query(sprintf("
				SELECT p.id_producto, p.nombre, p.marca, p.modelo, 
						p.cantidad_existencia, p.descripcion, p.precio, 
						p.categoria, c.nombre AS nombrecat, 
						p.proveedor, prov.nombre AS nombreprov 
				FROM productos AS p 
				JOIN categorias AS c ON c.id_categoria=p.categoria 
				JOIN proveedor AS prov ON prov.id_proveedor=p.proveedor 
				WHERE p.removed = 0 AND p.empresa = '%d' AND p.id_producto = '%d'",
				$this->UserData->getEmpresa(), $this->getHttpVars()->post("id") )
			)
		)
		{
			//$existe = true;
			$listProductos = array();
			if($pro = $this->getDatabase()->FetchArray($query_producto)){
				array_push($listProductos, array(
					'id'=> $pro['id_producto'],
					'nombre' => $pro['nombre'],
					'marca' => $pro['marca'],
					'modelo' => $pro['marca'],
					'cantidad_existencia' => $pro['cantidad_existencia'],
					'descripcion' => $pro['descripcion'],
					'precio' => $pro['precio'],
					'categoria' => 
						array(
							'id'=> $pro['categoria'],
							'nombre' => $pro['nombrecat']
						),
					'proveedor' => 
						array(
							'id' => $pro['proveedor'],
							'nombre' => $pro['nombreprov']
						)
				));
			}
			echo json_encode($listProductos);
		}
	}else if($this->getHttpVars()->isSetPost("nombre") && $this->getHttpVars()->isSetPost("categoria") && $this->getHttpVars()->isSetPost("nombre")){
		$sql = sprintf("
				SELECT p.id_producto, p.nombre, p.marca, p.modelo, 
						p.cantidad_existencia, p.descripcion, p.precio, 
						p.categoria, c.nombre AS nombrecat, 
						p.proveedor, prov.nombre AS nombreprov 
				FROM productos AS p 
				JOIN categorias AS c ON c.id_categoria=p.categoria 
				JOIN proveedor AS prov ON prov.id_proveedor=p.proveedor 
				WHERE p.removed = 0 AND p.empresa = '%d'  
				AND (p.nombre LIKE '%s' OR p.descripcion LIKE '%s' OR p.marca LIKE '%s' OR p.modelo LIKE '%s') 
				AND IF('%d'=0, TRUE, p.categoria = '%d') 
				AND IF('%d'=0, TRUE, p.proveedor = '%d') 
				LIMIT 3",
				$this->UserData->getEmpresa(),
				'%'.$this->getHttpVars()->post("nombre").'%',
				'%'.$this->getHttpVars()->post("nombre").'%',
				'%'.$this->getHttpVars()->post("nombre").'%',
				'%'.$this->getHttpVars()->post("nombre").'%',
				$this->getHttpVars()->post("categoria"),
				$this->getHttpVars()->post("categoria"),
				$this->getHttpVars()->post("proveedor"),
				$this->getHttpVars()->post("proveedor"));

		//echo $sql;


		if($query_producto = $this->getDatabase()->Query($sql))
		{
			//$existe = true;
			$listProductos = array();
			while ($pro = $this->getDatabase()->FetchArray($query_producto)) {
				array_push($listProductos, array(
					'id'=> $pro['id_producto'],
					'nombre' => $pro['nombre'],
					'marca' => $pro['marca'],
					'modelo' => $pro['marca'],
					'cantidad_existencia' => $pro['cantidad_existencia'],
					'descripcion' => $pro['descripcion'],
					'precio' => $pro['precio'],
					'categoria' => 
						array(
							'id'=> $pro['categoria'],
							'nombre' => $pro['nombrecat']
						),
					'proveedor' => 
						array(
							'id' => $pro['proveedor'],
							'nombre' => $pro['nombreprov']
						)
				));
			}
			echo json_encode($listProductos);
		}
	}

	/*if(!$existe){
		echo json_encode(array("ERROR"=> "El producto no existe."));
	}*/