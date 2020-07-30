<?php
	// oobtine el tamaño que tendra la imagen
	$aspec = ($this->GetUrl->url(2)!=false) ? $this->GetUrl->url(2) : 300;
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

	$producto_id = ($this->GetUrl->url(3)!=false) ? $this->GetUrl->url(3) : 0;
	$producto_id = (int)$producto_id;

	$folder =  __PATH_SOURCE__."/thumbs_producto/".$producto_id;
	$file_image = $folder."/image_".$aspec.".jpg";
	

	$create_image = true;
	if(file_exists($folder)){
		if(file_exists($file_image)){
			$thumb = imagecreatefromjpeg($file_image);
			$create_image = false;
		}
	}else{
		//mkdir($folder);
	}

	$data64 = "";
	if ($create_image) {
		if($producto_id>0){
			$query = $this->getDatabase()->Query(
				sprintf("SELECT po_foto FROM t_producto WHERE id_producto = '%d' AND po_foto<>''",$producto_id)
			);
			if($query && $query->num_rows==1){
				//$base64foto = $this->getDatabase()->FetchArray($query)['po_foto'];
				$data64 = explode(";base64,",$this->getDatabase()->FetchArray($query)['po_foto'])[1];
				//$data64 = $this->getDatabase()->FetchArray($query)['po_foto'];
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
				if(!file_exists($folder)){
					mkdir($folder);
				}
				
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
			}
		}
	}
	if($data64=="" && $create_image==true){
		header("HTTP/1.0 404 Not Found");
	}else{
		header('Content-type: image/jpeg');
		imagejpeg($thumb,null,75);
		imagedestroy($thumb);
	}
?>