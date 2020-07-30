<?php
	function getIcon($page){
		$icon = "";
		switch ($page) {
			case 'home':
					$icon = 'home';
				break;

			case 'facturar':
					$icon = 'store';
				break;

			case 'productos':
					$icon = 'shopping_basket';
				break;

			case 'proveedores':
					$icon = 'assignment';
				break;

			case 'profile':
					$icon = 'account_circle';
				break;

			case 'logout':
					$icon = 'exit_to_app';
				break;
		}
		return $icon;
	}
?>
		
		<header class="navbar navbar-fixed-top permanent__navdrawer">
			<div class="nav__container navbar navbar-dark navbar-expand">

				<button aria-controls="navdrawer" aria-expanded="false" aria-label="Toggle Navdrawer" class="navbar-toggler" data-target="#navdrawer" data-toggle="navdrawer">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!--<a class="navbar__logo" href="#">
					<img class="navbar__logo_icon" src="<?php echo _DIR_;?>src/images/logos/g1330.png">
					<img class="navbar__logo_text" src="<?php echo _DIR_;?>src/images/logos/g1309.png">
				</a>-->

				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active" aria-current="page">
							<i class="material-icons mr-3"><?php echo getIcon($this->GetUrl->getListUrl()[0]); ?></i>
							<?php echo $view->getTitulo();?>	
						</li>
					</ol>
				</nav>
			</div>
		</header>

		<div aria-hidden="true" class="navdrawer navdrawer-permanent shadow-6 navdrawer__main" id="navdrawer" tabindex="-1">
			<div class="navdrawer-content">

				<div class="navdrawer__logo" style="background-image: url('<?php echo $this->UserData->getFoto(); ?>')"></div>

				
				<div class="navdrawer-divider"></div>
				<ul class="navdrawer-nav">
					<li class="nav-item">
						<a class="nav-link <?php $isSelectPage('home'); ?>" href="<?php echo _DIR_."home";?>">
							<i class="material-icons mr-3">home</i>
							Inicio
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php $isSelectPage('facturar'); ?>" href="<?php echo _DIR_."facturar";?>">
							<i class="material-icons mr-3">store</i>
							Facturar
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php $isSelectPage('productos'); ?>" href="<?php echo _DIR_."productos";?>">
							<i class="material-icons mr-3">shopping_basket</i>
							Productos
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php $isSelectPage('proveedores'); ?>" href="<?php echo _DIR_."proveedores";?>">
							<i class="material-icons mr-3">assignment</i>
							Proveedores
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php $isSelectPage('profile'); ?>" href="<?php echo _DIR_."profile";?>">
							<i class="material-icons mr-3">account_circle</i>
							Perfil
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo _DIR_."logout";?>">
							<i class="material-icons mr-3">exit_to_app</i>
							Cerrar
						</a>
					</li>
				</ul>
			</div>
		</div>

		<section class="main main__access">
			<script type="text/javascript">
				$(window).resize(function() {
					if($(window).outerWidth()>800){
						$("#navdrawer").addClass("navdrawer-permanent");
					}else{
						$("#navdrawer").removeClass("navdrawer-permanent");
					}
					$("section.main").css('padding-top',$("header").outerHeight());
				});
			</script>
