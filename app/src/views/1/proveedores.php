<?php

$query_prov = $this->getDatabase()->Query(sprintf("SELECT id_proveedor, nombre FROM proveedor WHERE empresa = '%d'",$this->UserData->getEmpresa()));
$listProv = array();
while ($prov = $this->getDatabase()->FetchArray($query_prov)) {
	array_push($listProv, (new app\Proveedor())->setIdProveedor($prov['id_proveedor'])->setNombreProveedor($prov['nombre']) );
}
?>
<section id="view_proveedores">
	<div class="title__page"><i class="material-icons mr-3">assignment</i> Proveedores</div>
	<div class="card">
		<div class="card-body">
			<h5 class="card-title"><span class="material-icons">assignment</span> Lista de proveedores</h5>
			
		<?php
			foreach ($listProv as $prov) {
		?>
				<div class="row" id="<?php echo "row_dir_".$prov->getIdProveedor() ?>" >
					<div class="col-4 col-md-3">Proveedor:</div>
					<div class="col-8 col-md-6"><?php echo $prov->getNombreProveedor(); ?></div>
					<div class="col-3 col__buttons" style="max-width: min-content; margin: 0px 0px 0px auto;">
						<div class="btn-group">
							<button type="button" class="btn btn-primary color-btn-card btn-sm" onclick="">
								<span class="material-icons">edit</span>
							</button>
						</div>
					</div>
				</div>

		<?php 
			} 
		?>
			

			<div class="row">
				<div class="col-12 col-md-12 d-flex flex-row-reverse">
					<button type="button" class="btn btn-primary color-btn-card" id="btn__add_prov">
						<span class="material-icons">add</span>
						Agregar proveedor
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$("#btn__add_prov").click(function() {
		var dialog = new Dialog();
		dialog.setTitle("Agregar proveedor")
		.addClassDialogCard("dialog__proveedor")
		.setContent(`
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="msg_error bg-danger text-white">
						<span class="material-icons">warning</span>
						<span class="msg">Compruebe que los campos estén correctos</span>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__nom_prov">Nombre del proveedor:</label>
						<input type="text" class="form-control" id="itext__nom_prov" placeholder="Nombre del proveedor">
						<small id="small_itext__nom_prov" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
			</div>
		`)
		.setActions(["Cerrar","Agregar"])
		.setActionClick(0,function(){
			dialog.hide();
		})
		.setActionClick(1,function(){
			if($("#itext__nom_prov").val().trim()!=""){
				dialog.removeClassDialogCard("error_show");
				$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",true);
				Util.post('proveedores/addproveedor',{'nom_prove':$("#itext__nom_prov").val().trim()},function(resp,status){
					var showError = false;
					$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",false);
					try{
						var result = JSON.parse(resp);
						if(typeof result.ADDED != "undefined"){
							if(result.ADDED){
								window.location = '<?php echo _DIR_."proveedores"; ?>';
							}else{
								$("#"+dialog.getId()+" .msg_error .msg").html(result.ERROR);
								dialog.addClassDialogCard("error_show");
							}
						}else{showError = true;}
					}catch(e){
						showError = true;
					}
					if(showError){
						$("#"+dialog.getId()+" .msg_error .msg").html("No se puedo agregar el proveedor debido a un fallo interno, discúlpanos los inconvenientes.");
						dialog.addClassDialogCard("error_show");
					}
				});
			}
		})
		.addHideEvent(function(){
			dialog.destroy();
		})
		.setFullSize(true).show();
		setTimeout(function() {
			$("#itext__nom_prov").keydown(function(e){
				var root = this;
				setTimeout(function() {
					if($(root).val().trim()==""){
						if(!$(root).parent().hasClass("error__msg")){
							$(root).parent().addClass("error__msg");
						}	
					}else if($(root).parent().hasClass("error__msg")){
						$(root).parent().removeClass("error__msg");
					}
				}, 10);
			});
		}, 100);

	});

	function edit(idprov,nombreprov){
		var dialog = new Dialog();
		dialog.setTitle("Agregar proveedor")
		.addClassDialogCard("dialog__proveedor")
		.setContent(`
			<div class="row">
				<div class="col-12 col-md-12">
					<div class="msg_error bg-danger text-white">
						<span class="material-icons">warning</span>
						<span class="msg">Compruebe que los campos estén correctos</span>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__nom_prov">Nombre del proveedor:</label>
						<input type="text" val="`+nombreprov+`" class="form-control" id="itext__nom_prov" placeholder="Nombre del proveedor">
						<small id="small_itext__nom_prov" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
			</div>
		`)
		.setActions(["Cerrar","Agregar"])
		.setActionClick(0,function(){
			dialog.hide();
		})
		.setActionClick(1,function(){
			if($("#itext__nom_prov").val().trim()!=""){
				dialog.removeClassDialogCard("error_show");
				$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",true);
				Util.post('addproveedor',{'nom_prove':$("#itext__nom_prov").val().trim()},function(resp,status){
					var showError = false;
					$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",false);
					try{
						var result = JSON.parse(resp);
						if(typeof result.UPDATED != "undefined"){
							if(result.UPDATED){
								window.location = '<?php echo _DIR_."proveedores"; ?>';
							}else{
								$("#"+dialog.getId()+" .msg_error .msg").html(result.ERROR);
								dialog.addClassDialogCard("error_show");
							}
						}else{showError = true;}
					}catch(e){
						showError = true;
					}
					if(showError){
						$("#"+dialog.getId()+" .msg_error .msg").html("No se puedo agregar el proveedor debido a un fallo interno, discúlpanos los inconvenientes.");
						dialog.addClassDialogCard("error_show");
					}
				});
			}
		})
		.addHideEvent(function(){
			dialog.destroy();
		})
		.setFullSize(true).show();
		setTimeout(function() {
			$("#itext__nom_prov").keydown(function(e){
				var root = this;
				setTimeout(function() {
					if($(root).val().trim()==""){
						if(!$(root).parent().hasClass("error__msg")){
							$(root).parent().addClass("error__msg");
						}	
					}else if($(root).parent().hasClass("error__msg")){
						$(root).parent().removeClass("error__msg");
					}
				}, 10);
			});
		}, 100);

	}


</script>