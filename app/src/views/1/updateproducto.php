<?php

if(
	$this->getHttpVars()->isSetPost("id") && 
	$this->getHttpVars()->isSetPost("nombre") &&
	$this->getHttpVars()->isSetPost("cantidad") &&
	$this->getHttpVars()->isSetPost("precio") &&
	$this->getHttpVars()->isSetPost("proveedor") &&
	$this->getHttpVars()->isSetPost("categoria") &&
	$this->getHttpVars()->isSetPost("proveedor")>0 &&
	$this->getHttpVars()->isSetPost("categoria")>0
){
	$producto = new app\Producto();
	$producto->setId($this->getHttpVars()->post("id"))
		->setNombre($this->getHttpVars()->post("nombre"))
		->setMarca($this->getHttpVars()->isSetPost("marca") ? $this->getHttpVars()->post("marca") : "")
		->setModelo($this->getHttpVars()->isSetPost("modelo") ? $this->getHttpVars()->post("modelo") : "")
		->setCantidadExistencia($this->getHttpVars()->post("cantidad"))
		->setPrecio($this->getHttpVars()->post("precio"))
		->setDescripcion($this->getHttpVars()->isSetPost("descripcion") ? $this->getHttpVars()->post("descripcion") : "")
		->setProveedor($this->getHttpVars()->post("proveedor"),"")
		->setCategoria($this->getHttpVars()->post("categoria"),"");

	if($this->getDatabase()->Query(
		sprintf(
			"UPDATE productos SET 
			nombre = '%s', 
			marca = '%s', 
			modelo = '%s', 
			cantidad_existencia = '%d', 
			precio = '%f', 
			descripcion = '%s', 
			proveedor = '%d', 
			categoria = '%d' 
			WHERE id_producto = '%d' AND empresa = '%d'",
			$producto->getNombre(),
			$producto->getMarca(),
			$producto->getModelo(),
			$producto->getCantidadExistencia(),
			$producto->getPrecio(),
			$producto->getDescripcion(),
			$producto->getProveedor()->getIdProveedor(),
			$producto->getCategoria()->getId(),
			$producto->getId(),
			$this->UserData->getEmpresa()
		)
	)){
		echo json_encode(array(
			"ADDED"=> true
		));
	}else{
		echo json_encode(array(
			"ADDED"=> false,
			'TYPE_ERROR' => "INTERNAL",
			'ERROR' => "No se puedo agregar el proveedor debido a un fallo interno, discúlpanos los inconvenientes."
		));
	}
}else{
	echo json_encode(array(
		"ADDED"=> false,
		'TYPE_ERROR' => "DATA",
		'ERROR' => "Compruebe que los campost estén correctos y debidamente completados."
	));
}
