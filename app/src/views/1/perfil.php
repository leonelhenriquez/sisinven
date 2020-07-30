<section id="view_profile" class="card">
	<div class="card-body">
		<!--<h5 class="card-title">Perfil</h5>-->
		<div class="box_foto_perfil">
			<div class="container__box_perfil">
				<div class="foto_perfil"  style="background-image: url('<?php echo $this->UserData->getFoto(); ?>');">
					<label for="buttonFileProfile"></label>
					<input type="file" id="buttonFileProfile">
					<div class="progress-circular">
						<div class="progress-circular-wrapper">
							<div class="progress-circular-inner">
								<div class="progress-circular-left">
									<div class="progress-circular-spinner"></div>
								</div>
								<div class="progress-circular-gap"></div>
								<div class="progress-circular-right">
									<div class="progress-circular-spinner"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="nombre_perfil"><?php echo $this->UserData->getNombre()." ".$this->UserData->getApellido(); ?></div>
			</div>
		</div>
		<div class="card profile_data_box">
			<div class="card-body">
				<h5 class="card-title"><span class="material-icons">account_circle</span> Información persona</h5>
				<div class="row">
					<div class="col-4 col-md-3">Nombre:</div>
					<div class="col"><?php echo $this->UserData->getNombre(); ?></div>
				</div>
				<div class="row">
					<div class="col-4 col-md-3">Apellido:</div>
					<div class="col"><?php echo $this->UserData->getApellido(); ?></div>
				</div>
				<div class="row">
					<div class="col-12 col-md-12 d-flex flex-row-reverse">
							<button type="button" class="btn btn-primary color-btn-card" onclick="editProfile()">
								<span class="material-icons">edit</span>
								Editar información
							</button>
					</div>
				</div>
			</div>
		</div>



		<div class="card profile_data_box" style="margin-top: 32px;">
			<div class="card-body">
				<h5 class="card-title"><span class="material-icons">security</span> Seguridad</h5>
				<div class="row">
					<div class="col-4 col-md-3">Contraseña:</div>
					<div class="col">
						<?php echo "Contraseña modificada el ".$this->UserData->getPasswordChangedDate('d/m/Y')." a las ".$this->UserData->getPasswordChangedDate('g:i a'); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-12 d-flex flex-row-reverse">
							<button type="button" class="btn btn-primary color-btn-card" onclick="changePassword()">
								<span class="material-icons">lock</span>
								Cambiar contraseñá
							</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php


	$html_dialog = (str_replace("\n","",
		sprintf('
			<form class="row">
					<div class="col-12 col-md-12">
						<div class="msg_error bg-danger text-white">
							<span class="material-icons">warning</span>
							<span class="msg">Compruebe que los campos estén correctos</span>
						</div>
					</div>
					<div class="col-12 col-md-12">
						<div class="form-group">
							<label for="itext__nombre">Nombre</label>
							<input type="text" class="form-control" id="itext__nombre" placeholder="Nombre" value="%s">
							<small id="small__itext__nombre" class="form-text text-muted error__input">Error el campo esta vacio.</small>
						</div>
					</div>
					<div class="col-12 col-md-12">
						<div class="form-group">
							<label for="itext__apellido">Apellido</label>
							<input type="text" class="form-control" id="itext__apellido" placeholder="Apellido" value="%s">
							<small id="small__itext__apellido" class="form-text text-muted error__input">Error el campo esta vacio.</small>
						</div>
					</div>
			</form>
			',
			$this->UserData->getNombre(),
			$this->UserData->getApellido()
		)
	));
?>
<script type="text/javascript">
	function editProfile(){
		var dialog = new Dialog();
		dialog.setTitle("Editar información persona")
		.addClassDialogCard("dialog_profile")
		.setContent((`<?php echo $html_dialog; ?>`))
		.setActions(['Cerrar','Guardar'])
		.setActionClick(0,function(){
			dialog.hide();
		})
		.setActionClick(1,function(){
			var data = {
				'nombre': $("#itext__nombre").val().trim(),
				'apellido': $("#itext__apellido").val().trim()
			};
			if(data.nombre!="" && data.apellido!=""){
				dialog.removeClassDialogCard("error_show");
				$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",true);
				Util.post('profile/update_data',data,function(resp,status){
					var showError = false;
					$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",false);
					try{
						var result = JSON.parse(resp);
						//console.log(result);
						if(typeof result.UPDATED != "undefined"){
							if(result.UPDATED){
								var dialogUPDATED = new Dialog();
								dialogUPDATED.setTitle("Actualizado")
										.setContent("Los datos se actualizaron correctamente")
										.setActions(['Ok'])
										.setActionClick(0,function(){
											setTimeout(function() {
												window.location = '<?php echo _DIR_."/profile"; ?>';
											}, 300);
										}).show();

								setTimeout(function() {
									window.location = '<?php echo _DIR_."profile"; ?>';
								}, 3000);
							}else{
								if(result.TYPE_ERROR=="EMIAL"){
									$("#itext__email").parent().addClass("error__msg");
								}
								$("#"+dialog.getId()+" .msg_error .msg").html(result.ERROR);
								dialog.addClassDialogCard("error_show");
							}

						}else{
							showError = true;
						}
					}catch(e){
						//console.log(e);
						showError = true;
					}
					if(showError){
						$("#"+dialog.getId()+" .msg_error .msg").html("No se puedo actualizar la información del perfil debido a un fallo interno, discúlpanos los inconvenientes.");
						dialog.addClassDialogCard("error_show");
					}

				});
			}else{
				$("#"+dialog.getId()+" .msg_error .msg").html("Compruebe que los campos estén correctos");
				dialog.addClassDialogCard("error_show");
			}

		})
		.addHideEvent(function(){
			dialog.destroy();
		})
		.setFullSize(true).show();

		setTimeout(function() {
			$("#itext__nombre,#itext__apellido").keydown(function(e){
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
	/*function comprobarCampos(data){
		return data.nombre!="" && data.apellido!="";
	}*/
	function validarEmail(valor) {emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;return emailRegex.test(valor);}
	$('input[type="file"]#buttonFileProfile').change(function(){
		if (this.files && this.files[0]) {
			var fileTypes = ['jpg', 'jpeg', 'png'];  //acceptable file types
			var extension = this.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
            	isSuccess = fileTypes.indexOf(extension) > -1;//is extension in acceptable typ
			if(isSuccess){
				$('#view_profile .box_foto_perfil .foto_perfil').addClass('load');
				//return true;
				var FR= new FileReader();
				FR.addEventListener("load", function(e) {
					img = e.target.result;
					if(img!=null){
						$('#view_profile .box_foto_perfil .foto_perfil').css({'background-image': 'url('+img+')'});

						var datos = new FormData();
						
						datos.append('files-0', $('input[type="file"]#buttonFileProfile')[0].files[0]);
						datos.append('foto',"si");
						//$('#view_profile .box_foto_perfil .foto_perfil').removeClass('load');
						Util.post('profile/update_data',datos,function(data,status){
							//window.location = '<?php echo _DIR_."profile"; ?>';
							$('#view_profile .box_foto_perfil .foto_perfil').removeClass('load');
						});
					}
				});
				FR.readAsDataURL(this.files[0]);
			}
		}
	});
	function changePassword(){
		var dialog = new Dialog()
		dialog.addClassDialogCard("dialog_profile").setTitle("Cambiar contraseña")
		.setContent(`
			<form class="row">
				<div class="col-12 col-md-12">
					<div class="msg_error bg-danger text-white">
						<span class="material-icons">warning</span>
						<span class="msg">Compruebe que los campos estén correctos</span>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__password">Contraseña:</label>
						<input type="password" class="form-control" id="itext__password" placeholder="Contraseña">
						<small id="small_itext__password" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__new_password">Nueva contraseña: </label>
						<input type="password" class="form-control" id="itext__new_password" placeholder="Nueva contraseña">
						<small class="form-text text-muted error__input">La contraseña debe ser de almenos 6 caracteres.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__repeat_password">Repetir contraseña: </label>
						<input type="password" class="form-control" id="itext__repeat_password" placeholder="Repetir contraseña">
						<small class="form-text text-muted error__input">La contraseña no coincide.</small>
					</div>
				</div>
			</form>
		`)
		.setActions(['Cerrar','Guardar'])
		.setActionClick(0,function(){dialog.hide();})
		.setActionClick(1,function(){
			$("#small_itext__password").html("Error el campo esta vacio.");
			if($("#itext__password").val()!="" && $("#itext__repeat_password").val().length>=6 && $("#itext__repeat_password").val()==$("#itext__new_password").val()){
				Util.post('profile/update_data',
					{'pass':$("#itext__password").val(),'pass_new':$("#itext__new_password").val()},
					function(data,rep){
						var result = JSON.parse(data);
						if(result.UPDATED){
							dialog.hide();
						}else if(result.TYPE_ERROR=='PASSWORD'){
							$("#itext__password").parent().addClass("error__msg");
							$("#small_itext__password").html(result.ERROR);
						}else if(result.TYPE_ERROR=='INTERNAL'){
							$("#"+dialog.getId()+" .msg_error .msg").html(result.ERROR);
							dialog.addClassDialogCard("error_show");
						}
					});
			}else{
				$("#"+dialog.getId()+" .msg_error .msg").html("Compruebe que los campos estén correctos");
				dialog.addClassDialogCard("error_show");
			}
		})
		.addHideEvent(function(){dialog.destroy();}).setFullSize(true).show();
		setTimeout(function() {
			$("#itext__password").keydown(function(e){
				if($(this).val()==""){
					if(!$(this).parent().hasClass("error__msg")){
						$(this).parent().addClass("error__msg");
						$("#small_itext__password").html("Error el campo esta vacio.");
					}	
				}else if($(this).parent().hasClass("error__msg")){
					$(this).parent().removeClass("error__msg");
				}
			});
			$("#itext__new_password").keydown(function(e){
				setTimeout(function() {
					if($("#itext__new_password").val().length<6){
						if(!$("#itext__new_password").parent().hasClass("error__msg")){
							$("#itext__new_password").parent().addClass("error__msg");
						}	
					}else if($("#itext__new_password").parent().hasClass("error__msg")){
						$("#itext__new_password").parent().removeClass("error__msg");
					}

					if($("#itext__repeat_password").val()!=""){
						if($("#itext__repeat_password").val()!=$("#itext__new_password").val()){
							if(!$("#itext__repeat_password").parent().hasClass("error__msg")){
								$("#itext__repeat_password").parent().addClass("error__msg");
							}	
						}else if($("#itext__repeat_password").parent().hasClass("error__msg")){
							$("#itext__repeat_password").parent().removeClass("error__msg");
						}
					}
				}, 10);
			});
			$("#itext__repeat_password").keydown(function(e){
				setTimeout(function() {
					if($("#itext__repeat_password").val()!=$("#itext__new_password").val()){
						if(!$("#itext__repeat_password").parent().hasClass("error__msg")){
							$("#itext__repeat_password").parent().addClass("error__msg");
						}	
					}else if($("#itext__repeat_password").parent().hasClass("error__msg")){
						$("#itext__repeat_password").parent().removeClass("error__msg");
					}
				}, 10);
			});
		}, 100);
	}
</script>
