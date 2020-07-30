<?php
	$removed = false;
	if($this->getHttpVars()->isSetPost("id")){
		if($this->getDatabase()->Query(sprintf("UPDATE productos SET removed = 1 WHERE id_producto = '%d'",$this->getHttpVars()->post("id")))){
			$removed = true;
		}
	}
	echo json_encode(array("REMOVED"=>$removed));