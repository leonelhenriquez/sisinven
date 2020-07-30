<?php
	$login = function($pass){
		$sql = sprintf("SELECT password,key_pass FROM users WHERE id_user = '%d'",$this->UserData->getId());
		if($query = $this->getDatabase()->Query($sql)){
			if($user=mysqli_fetch_array($query)){
				if($this->Crypt->pass_verify($pass,$user['password'],$user['key_pass'])){
					return true;
				}
			}
		}
		return false;
	};
	if( $this->getHttpVars()->isSetPost("foto") && isset($_FILES['files-0'])) {
		if($_FILES['files-0']['type']=='image/png' || $_FILES['files-0']['type']=='image/jpeg'){
			
			$base_64  = $_FILES['files-0']['type']=='image/png' ? 'data:image/png;base64,' : 'data:image/jpeg;base64,';


			if($_FILES['files-0']['type']=='image/png'){
				$image = imagecreatefrompng($_FILES["files-0"]["tmp_name"]);
			}else{
				$image = imagecreatefromjpeg($_FILES["files-0"]["tmp_name"]);
			}

			$w = imagesx($image);
			$h = imagesy($image);
			$aspec = 1000;
			$size = min($aspec/$w,$aspec/$h);
			$size = ($size>1) ? 1 : $size;
			$new_w = $size*$w;
			$new_h = $size*$h;
			$thumb = imagecreatetruecolor($new_w, $new_h);
			imagecopyresized($thumb,$image,0, 0, 0, 0,$new_w,$new_h,$w,$h);

			//$base_64  = $_FILES['files-0']['type']=='image/png' ? 'data:image/png;base64,' : 'data:image/jpeg;base64,';
			ob_start();
			if($_FILES['files-0']['type']=='image/png'){
				imagepng($thumb);
			}else{
				imagejpeg($thumb);
			}
			$image_data = ob_get_contents();
			ob_end_clean();

			$base_64 .= base64_encode($image_data); 


			$this->getDatabase()->Query(sprintf("UPDATE users SET foto = '%s' WHERE id_user = '%d'",$base_64,$this->UserData->getId()));
			$folder = __PATH_SOURCE__."/thumbs/".$this->UserData->getId()."/";

			$files = scandir($folder);
			foreach ($files as $value) {
				if(!($value=="." || $value=="..")){
					unlink($folder.$value);
				}
			}
		}
	}else if(
		$this->getHttpVars()->isSetPost("nombre") &&
		$this->getHttpVars()->isSetPost("apellido")
	){
		if($this->getDatabase()->Query(
				sprintf(
					"UPDATE users SET nombre = '%s',apellido = '%s' WHERE id_user = '%d'",
					$this->getHttpVars()->post("nombre"),
					$this->getHttpVars()->post("apellido"),
					$this->UserData->getId())))
			{
				echo json_encode(array('UPDATED' => true));
			}else{
				echo json_encode(array(
					'UPDATED' => false,
					'TYPE_ERROR' => "INTERNAL",
					'ERROR' => "No se puedo actualizar la información del perfil debido a un fallo interno, discúlpanos los inconvenientes."
				));
			}
	}else if(
		$this->getHttpVars()->isSetPost("pass") && 
		$this->getHttpVars()->isSetPost("pass_new") && 
		strlen($this->getHttpVars()->post("pass_new"))>=6
	){
		if(
			$login($this->getHttpVars()->post("pass"))
		){
			$pass = $this->Crypt->pass_crypt($this->getHttpVars()->post("pass_new"));
			if($this->getDatabase()->Query(
				sprintf("UPDATE users SET password = '%s',key_pass = '%d', password_changed_date = '%s' WHERE id_user = '%d'",$pass['hash'],$pass['cc'],date('Y-m-d H:i:s'),$this->UserData->getId())
			)){
				echo json_encode(array(
					'UPDATED' => true
				));
			}else{
				echo json_encode(array(
					'UPDATED' => false,
					'TYPE_ERROR' => "INTERNAL",
					'ERROR' => "No se puedo actualizar la contraseña debido a un fallo interno, discúlpanos los inconvenientes."
				));
			}
		}else{
			echo json_encode(array(
				'UPDATED' => false,
				'TYPE_ERROR' => "PASSWORD",
				'ERROR' => "La contraseña que ingresaste es incorrecta."
			));
		}
	}else{
		echo json_encode(array(
			'UPDATED' => false,
			'TYPE_ERROR' => "DATA",
			'ERROR' => "Compruebe que los campos estén correctos y debidamente completados."
		));
	}
