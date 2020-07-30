		<header class="navbar navbar-fixed-top">
			<div class="nav__container navbar navbar-dark navbar-expand">
				<?php
				if($this->getSessionManager()->hasLogged() ){
				?>
				<button aria-controls="navdrawerDefault" aria-expanded="false" aria-label="Toggle Navdrawer" class="navbar-toggler" data-target="#navdrawerDefault" data-toggle="navdrawer">
					<span class="navbar-toggler-icon"></span>
				</button>
				<?php }else { ?>
				<button class="navbar-toggler navbar-toggler__no_access navdrawerNoAccess" type="button" data-target="#navdrawer__no_access" aria-expanded="false">
					<span class="navbar-toggler-icon navbar-toggler__no_access-icon"></span>
				</button>
				<?php } ?>
				<a class="navbar__logo" href="<?php echo _DIR_.$this->GetUrl->ListViewsUrl[1]; ?>">
					<img class="navbar__logo_icon" src="<?php echo _DIR_;?>src/images/logos/g1330.png">
					<img class="navbar__logo_text" src="<?php echo _DIR_;?>src/images/logos/g1309.png">
				</a>
				<div class="collapse navbar-collapse">
					<?php require __DIR_THEME_HEADER__.'header/0/menu.php'; ?>
				</div>
			</div>
		</header>

		<div class="navdrawer__no_access" id="navdrawer__no_access">
			<button class="navbar-toggler navbar-toggler__no_access navdrawerNoAccess" type="button" data-target="#navdrawer__no_access" aria-expanded="false">
				<i class="material-icons">close</i>
			</button>
			<?php require __DIR_THEME_HEADER__.'header/0/menu.php'; ?>
		</div>


		<script type="text/javascript">
				function movePosition(id) {
					$("html,body").animate({scrollTop:$("#"+id).position().top - $("header").outerHeight()},1000);
					return false;
				}
		</script>




		<script type="text/javascript">
			$(".navdrawerNoAccess").on("click",function(){
				if($($(this).attr("data-target")).hasClass("show")){
					$(this).removeClass("show");
					$("body").css('overflow','auto');
					$($(this).attr("data-target")).removeClass("show");
				}else{
					$(this).addClass("show");
					$($(this).attr("data-target")).addClass("show");
					$("body").css('overflow','hidden');
				}
			});
		</script>
		<?php if($this->getSessionManager()->hasLogged() ){ ?>
		<div aria-hidden="true" class="navdrawer" id="navdrawerDefault" tabindex="-1">
			<div class="navdrawer-content">
				<div class="navdrawer-header">
					<a class="navbar-brand px-0" href="#">Navdrawer header</a>
				</div>
				<nav class="navdrawer-nav">
					<a class="nav-item nav-link active" href="#">Active</a>
					<a class="nav-item nav-link disabled" href="#">Disabled</a>
					<a class="nav-item nav-link" href="#">Link</a>
				</nav>
				<div class="navdrawer-divider"></div>
				<p class="navdrawer-subheader">Navdrawer subheader</p>
				<ul class="navdrawer-nav">
					<li class="nav-item">
						<a class="nav-link active" href="#"><i class="material-icons mr-3">alarm_on</i> Active with icon</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#"><i class="material-icons mr-3">alarm_off</i> Disabled with icon</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#"><i class="material-icons mr-3">link</i> Link with icon</a>
					</li>
				</ul>
			</div>
		</div>
		<?php } ?>
		<section class="main">
			<script type="text/javascript">
				$(window).resize(function() {
					$("section.main").css('margin-top',$("header").outerHeight());
				});
			</script>