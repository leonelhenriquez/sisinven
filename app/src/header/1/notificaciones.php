
<?php if(!$isSelectUrl(11) && !$isSelectUrl(13) && !$isSelectUrl(8) && !$this->UserData->getPago()){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function() {
		dialogPago = new Dialog();
		dialogPago//.setTitle("Pago")
			.setContent(`
				<div class="title_pago"></div>
				<div class="content_pago">
					Membresía Young Social Club durante 1 año.<br><br>
					<ul>
						<li>Acumula hasta 1500 puntos.</li>
						<li>Derecho a 50 clubes al mes.</li>
						<li>Cambio de puntos con marcas Reconocidas a nivel nacional.</li>
					</ul>
				</div>
				<div class="price">$<?php echo $this->UserData->getMemberPrice();?> USD anual</div>
				`)
			.setActions(['Adquirir membresía','Cerrar'])
			.setActionClick(1,function(){
				dialogPago.hide().destroy();
			})
			.setActionClick(0,function(){
				window.location = '<?php echo _DIR_.$this->GetUrl->ListViewsUrl[11]; ?>';
			})
			.setOverlayClose(true)
			.setOverlayCloseEvent(function(){
				dialogPago.destroy();
			}).show();
			$("#"+dialogPago.getId()+" .dialog-box").addClass("mdc-card pago");
			$(dialogPago.getAction(0)).addClass("bt_pagos");
			$(dialogPago.getAction(1)).addClass("close_dialog_member");
		}, 0);
	});
</script>
<?php } ?>