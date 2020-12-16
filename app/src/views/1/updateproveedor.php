<?php
if ($this->getHttpVars()->isSetPost("id") && $this->getHttpVars()->isSetPost("name")) {
	if($this->getDatabase()->Query(
		sprintf(
			"UPDATE proveedor SET nombre = '%s' WHERE id_proveedor = '%d' AND empresa = '%d'",
			$this->getHttpVars()->post("name"),
			$this->getHttpVars()->post("id"),
			$this->UserData->getEmpresa()
		)
	)){
		echo json_encode(array(
			"UPDATED"=> true
		));
	}else{
		echo json_encode(array(
			"UPDATED"=> false,
			'TYPE_ERROR' => "INTERNAL",
			'ERROR' => "No se puedo actulizar el proveedor debido a un fallo interno, discúlpanos los inconvenientes."
		));
	}
}else{
	echo json_encode(array(
		"UPDATED"=> false,
		'TYPE_ERROR' => "DATA",
		'ERROR' => "Compruebe que los campos estén correctos y debidamente completados."
	));
}