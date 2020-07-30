<?php
	$menu = array();
	if($this->session->hasLogged()){
			$menu = array(
				array(
					'text'	=> 'Inicio',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[1],
					'class'	=> $isSelectUrl(1) ? 'active' : '',
				),array(
					'text'	=> 'Mi árbol',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[7],
					'class'	=> $isSelectUrl(7) ? 'active' : '',
				),array(
					'text'	=> 'Perfil',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[10],
					'class'	=> $isSelectUrl(10) ? 'active' : '',
				),array(
					'text'	=> 'Membresía',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[11],
					'class'	=> $isSelectUrl(11) ? 'active' : '',
				),array(
					'text'	=> 'Cerrar sesión',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[8],
				),
			);
	}else{
		if($isSelectUrl(1)){
			$menu = array(
				array(
					'text'	=> 'Inicio',//$this->lang->getString('Inicio'),
					'href'	=> '#home',
					'class'	=> 'first active scroll_btn',
				),array(
					'text'	=> 'Quienes somos',
					'href'	=> '#about',
					'class'	=> 'scroll_btn',
				),array(
					'text'	=> 'Registrarse',
					'href'	=> '#reg',
					'class'	=> 'scroll_btn',
				),array(
					'text'	=> 'Iniciar sesión',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[2],
				),array(
					'text'	=> 'Contactanos',
					'href'	=> '#foot',
					'class'	=> 'scroll_btn',
				)/*,array(
					'text'		=> 'Liderazgo',
					'href'		=> 'http://pncoaching.com/',
					'target'	=> '_blank',
				)*/
			);
		}else{
			$menu = array(
				array(
					'text'	=> 'Inicio',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[1].'#home',
				),array(
					'text'	=> 'Quienes somos',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[1].'#about',
				),array(
					'text'	=> 'Registrarse',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[3],
					'class'	=> $isSelectUrl(3) ? 'active' : '',
				),array(
					'text'	=> 'Iniciar sesión',
					'href'	=> _DIR_.$this->GetUrl->ListViewsUrl[2],
					'class'	=> $isSelectUrl(2) ? 'active' : '',
				),array(
					'text'	=> 'Contactanos',
					'href'	=> _DIR_.'#foot',
				)/*,array(
					'text'		=> 'Liderazgo',
					'href'		=> 'http://pncoaching.com/',
					'target'	=> '_blank',
				)*/
			);
		}
	}
	if(isset($menu)){
		foreach ($menu as &$itemMenu) {
			echo "<li".(isset($itemMenu['class']) ? ' class="'.$itemMenu['class'].'"' : '')."><a href=\"".$itemMenu['href']."\"".((isset($itemMenu['target'])) ? ' target="'.$itemMenu['target'].'"' : '').">".$itemMenu['text']."</a></li>\n";
		}
	}
	/*
?>
	<li class="first active scroll_btn"><a href="#home" >Inicio</a></li>
	<li class="scroll_btn"><a href="#about" >Quienes somos</a></li>
	<li class="scroll_btn"><a href="#reg" >Registrarse</a></li>
	<li class="scroll_btn"><a href="#foot" >Contactanos</a></li>
	<li><a href="login.php" >Iniciar sesión</a></li>
	<li><a href="http://pncoaching.com/" target="_blank">Liderazgo</a></li>*/