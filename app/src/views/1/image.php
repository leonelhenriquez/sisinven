<?php
	// oobtine el tamaño que tendra la imagen
	$aspec = isset($this->GetUrl->getListUrl()[1]) ? $this->GetUrl->getListUrl()[1] : 300;
	$aspec = (int)$aspec;
	$aspec = ($aspec==0) ? 300 : $aspec;

	$long = strlen($aspec);
	//exit($long."");
	if($long>2){
		$aspec = ( (int)($aspec/pow(10,$long-2)) )*pow(10,$long-2);
	}else{
		$aspec = ( (int)($aspec/10)  ); 
		$aspec = ($aspec==0 ? 1 : $aspec)*10;
	}
	$aspec = ($aspec>2000) ? 2000 : $aspec;

	//$user_id = ($this->GetUrl->url(3)!=false) ? $this->GetUrl->url(3) : 0;
	//$user_id = (int)$user_id;
	$user_id = $this->UserData->getId();
	//exit()

	$folder =  __PATH_SOURCE__."/thumbs/".( ($user_id==0) ? $this->UserData->getId() : $user_id );
	$file_image = $folder."/image_".$aspec.".jpg";

	$create_image = true;
	if(file_exists($folder)){
		if(file_exists($file_image)){
			$thumb = imagecreatefromjpeg($file_image);
			$create_image = false;
		}
	}else{
		mkdir($folder);
	}
	$data64 = "";
	if ($create_image) {
		/*if($user_id==0 || $user_id==$this->UserData->getId()){
			$data64 = explode(";base64,",$this->UserData->getFoto())[1];
		}else */
		if($user_id>0){
			$query = $this->getDatabase()->Query(
				sprintf("SELECT foto FROM users WHERE id_user = '%d' AND foto<>''",$user_id)
			);
			if($query && $query->num_rows==1){
				$base64foto = $this->getDatabase()->FetchArray($query)['foto'];
				$data64 = explode(";base64,",$base64foto)[1];
			}
		}
		if($data64!=""){
			$w = 0;$h = 0;$size = 0;$size = 0;$new_w = 0;$new_h = 0;
			$image = imagecreatefromstring(base64_decode($data64));
			$w = imagesx($image);
			$h = imagesy($image);
			$size = max($aspec/$w,$aspec/$h);

			if($size>1){
				$file_image = $folder."/image_".max($w,$h).".jpg";
				if(file_exists($file_image)){
					$thumb = imagecreatefromjpeg($file_image);
					$create_image = false;
				}
			}
			if($create_image){
				$size = ($size>1) ? 1 : $size;
				$new_w = $size*$w;
				$new_h = $size*$h;

				$thumb = imagecreatetruecolor($new_w, $new_h);
				$fondo = imagecolorallocate($thumb, 255, 255, 255);
				imagefilledrectangle($thumb, 0, 0, $new_w, $new_h, $fondo);
				imagecopyresized($thumb,$image,0, 0, 0, 0,$new_w,$new_h,$w,$h);
				imagejpeg($thumb,$file_image,75);

				$image = null;
				$fondo = null;
				unset($image);
				unset($fondo);




				/*$thumb = imagecreatetruecolor($new_w, $new_h);
				imagecopyresized($thumb,$image,0, 0, 0, 0,$new_w,$new_h,$w,$h);
				imagejpeg($thumb,$file_image,80);*/
			}
		}
	}
	if($data64=="" && $create_image==true){
		header("HTTP/1.0 404 Not Found");
	}else{
		header('Content-type: image/jpeg');
		imagejpeg($thumb);
		imagedestroy($thumb);
	}
?>