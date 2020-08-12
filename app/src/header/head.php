<?php
	$isSelectPage = function($page,$print=true){
		if($this->GetUrl->getListUrl()[0]==$page){
			if($print){
				echo 'active';
			}else{
				return 'active';
			}
		}
	};
	$isSelectUrl = function($page){
		return $this->GetUrl->getListUrl()[0]==$page;
	};
	$isSelectTab = function($page){
		if($this->GetUrl->getListUrl()[0]==$page){
			echo 'is-active';
		}
	};
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset='utf-8'>
		<title><?php echo $view->getTitulo();?></title>
		<!--<link rel="shortcut icon" href="icono.ico">-->
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no,  minimum-scale=1.0, maximum-scale=1.0">
		
		<link rel="stylesheet" href="<?php echo _DIR_;?>src/css/style.css">
		<link rel="stylesheet" href="<?php echo _DIR_;?>src/css/util.css">
		<link rel="stylesheet" href="<?php echo _DIR_;?>src/fonts/material_icons.css">
		<link rel="stylesheet" href="<?php echo _DIR_;?>node_modules/daemonite-material/css/material.min.css">

		<script src="<?php echo _DIR_;?>node_modules/jquery/dist/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo _DIR_;?>node_modules/jquery-mask-plugin/dist/jquery.mask.min.js" type="text/javascript"></script>
		<script src="<?php echo _DIR_;?>node_modules/jquery-mask-as-number/jquery-mask-as-number.min.js" type="text/javascript"></script>
		<script src="<?php echo _DIR_;?>src/js/util.js" type="text/javascript"></script>
		<script src="<?php echo _DIR_;?>node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
		<script src="<?php echo _DIR_;?>node_modules/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo _DIR_;?>node_modules/daemonite-material/js/material.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$.jMaskGlobals.watchDataMask= true;
			function keyFloatEvent(e){
				var root = this;
				//console.log(e.key);
				//console.log(e.which);
				var txt = $(this).val();
				//console.log(txt.split(".").length==2 ? txt.split(".")[1].length<=2 : true);
				if(!(
					(!isNaN(parseInt(e.key)) && parseInt(e.key)>=0 && parseInt(e.key)<=9 && (txt.split(".").length==2 ? txt.split(".")[1].length<=2 : true ) ) || 
					(e.key=='.' && !txt.includes(".")) ||
					e.key=="Backspace"  || e.key=="Delete"  || e.key=="Enter"  || 
					e.key=="Control"  || e.key=="Alt"  || e.key=="AltGraph" || 
					e.key=="ArrowLeft" || e.key=="ArrowRight" || e.key=="ArrowUp" || 
					e.key=="ArrowDown" || e.key=="Tab" || e.key=="Shift"
				)){
					e.preventDefault();
				}
			}
		</script>

	</head>
	<body<?php if($this->getSessionManager()->hasLogged()){echo ' class="access"';}?>>
		
		<?php 
			if($this->getSessionManager()->hasLogged()){
				require __DIR_THEME_HEADER__.'header/1/head.php';
			}
		?>