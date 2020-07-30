<div class="card shadow" id="w_login">
	<form class="card-body">
		<div class="progress">
			<div class="progress-bar progress-bar-indeterminate" role="progressbar"></div>
		</div>
		<div class="card-title">Iniciar sesión</div>
		<div class="msg_error bg-danger text-white">
			<span class="material-icons">warning</span>
			<div class="txt__msg_error">Este es un mensaje de prueba de error por favor no tomar atencion</div>
		</div>
		<div class="floating-label">
			<label for="itext__user">Nombre de usuario</label>
			<input class="form-control" id="itext__user" placeholder="Nombre de usuario" type="text">
		</div>
		<div class="floating-label">
			<label for="itext__password">Contraseña</label>
			<input class="form-control" id="itext__password" placeholder="Contraseña" type="password">
		</div>
		<button type="button" class="btn btn__login" id="btn__login">Iniciar sesión</button>
	</form>
</div>

<script type="text/javascript">
	$("#itext__user").keydown(function(e){
		if(e.which==13){
			$("#itext__password").focus();
		}
	});
	$("#itext__password").keydown(function(e){
		if(e.which==13){
			$("#btn__login").trigger('click');
		}
	});

	$("#btn__login").click(function(){

		$("#w_login .progress").addClass("show");

		if($("#itext__user").val().length>0 && $("#itext__password").val().length>0){
			$("#w_login").addClass("load");
			//$("form.login-form input").prop("disabled",true);
			//setTimeout(function() {
				Util.post(
					'login/ais',
					{'user':$("#itext__user").val(),'pass':$("#itext__password").val()},
					function(resp,status){
						//alert(resp);
						obj = JSON.parse(resp);
						console.log(obj.status);
						if (obj.status=='VALID') {
							window.location = '<?php echo _DIR_."home"; ?>';
						}else{
							$("#w_login").removeClass("load").addClass("error_show");
							//$("form.login-form input").prop("disabled",false);
							$("#w_login .msg_error .txt__msg_error").html("El usuario ó la contraseña son incorrectos");
						}
					}
				);
			//}, 1700);
		}else{
			$("#w_login").removeClass("load").addClass("error_show");
			//$("form.login-form input").prop("disabled",false);
			if($("#itext__email").val().length==0 || $("#itext__password").val().length==0){
				$("#w_login .msg_error .txt__msg_error").html("Ingrese el usuario y la contraseña");
			}
		}
		return false;
	});
</script>
