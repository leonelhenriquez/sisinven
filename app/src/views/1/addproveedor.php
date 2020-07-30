<?php
if ($this->getHttpVars()->isSetPost("nom_prove")) {
	if($this->getDatabase()->Query(sprintf(
		"INSERT INTO proveedor (nombre,empresa) VALUES ('%s','%d')",
		$this->getHttpVars()->post("nom_prove"),
		$this->UserData->getEmpresa()
	))){
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
		'ERROR' => "Compruebe que los campos estén correctos y debidamente completados."
	));
}