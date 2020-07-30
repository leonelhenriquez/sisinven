<?php 
	$listPaises = array();
	$query_paises = $this->getDatabase()->Query("SELECT id_pais,cod_area,nom_pais FROM paises");
	while ($data_pais = $this->getDatabase()->FetchArray($query_paises)) {
		array_push($listPaises, new app\Pais(
									$data_pais['id_pais'],
									$data_pais['cod_area'],
									$data_pais['nom_pais']
								));
	}
	$this->getDatabase()->free($query_paises);


	$query_direcciones = $this->getDatabase()->Query(sprintf(
		"SELECT id_direccion, d_tipo, d_direccion, d_departamento, p.id_pais, p.cod_area, p.nom_pais
		FROM t_direcciones AS dir 
		JOIN paises AS p ON p.id_pais=dir.id_pais 
		WHERE id_persona = '%d' AND `d_tipo`='Personal'",
		$this->UserData->getId()
	));


		$query_direcciones2 = $this->getDatabase()->Query(sprintf(
		"SELECT id_direccion, d_tipo, d_direccion, d_departamento, p.id_pais, p.cod_area, p.nom_pais
		FROM t_direcciones AS dir 
		JOIN paises AS p ON p.id_pais=dir.id_pais 
		WHERE id_persona = '%d' AND `d_tipo`!='Personal'",
		$this->UserData->getId()
	));





	$listDirreciones = array();
	if($query_direcciones->num_rows>0){
		while($dataDir = $this->getDatabase()->FetchArray($query_direcciones)) {
			array_push($listDirreciones,
				new app\Direccion(
					$dataDir['id_direccion'],
					$this->UserData->getId(),
					$dataDir['d_tipo'],
					$dataDir['d_direccion'],
					$dataDir['d_departamento'],
					$dataDir['id_pais'],
					$dataDir['cod_area'],
					$dataDir['nom_pais']
				) 
			);
		}
	}
	$this->getDatabase()->free($query_direcciones);



	$listDirreciones2 = array();
	if($query_direcciones2->num_rows>0){
		while($dataDir = $this->getDatabase()->FetchArray($query_direcciones2)) {
			array_push($listDirreciones2,
				new app\Direccion(
					$dataDir['id_direccion'],
					$this->UserData->getId(),
					$dataDir['d_tipo'],
					$dataDir['d_direccion'],
					$dataDir['d_departamento'],
					$dataDir['id_pais'],
					$dataDir['cod_area'],
					$dataDir['nom_pais']
				) 
			);
		}
	}
	$this->getDatabase()->free($query_direcciones2);




$opciones_paises = "";
	foreach ($listDirreciones as $dir) {
		$opciones_paises .= 
			sprintf(
				'<option value="%s" %s>%s</option>',
				$dir->getIdDireccion(),
				($dir->getIdDireccion()==$this->UserData->getPaisCodigoArea()->getIdPais()) ? 'selected' : '',
				$dir->getDireccion().",".$dir->getDepartamento().",".$dir->getPais()->getNombre()
			);
	}


$opciones_paises2 = "";
	foreach ($listDirreciones2 as $dir) {
		$opciones_paises2 .= 
			sprintf(
				'<option value="%s" %s>%s</option>',
				$dir->getIdDireccion(),
				($dir->getIdDireccion()==$this->UserData->getPaisCodigoArea()->getIdPais()) ? 'selected' : '',
				"<b> Tipo: ".$dir->getTipo()." // </b> ".$dir->getDireccion().",".$dir->getDepartamento().",".$dir->getPais()->getNombre()
			);
	}


?>
<div class="container" id="view_producto">
		<center><h1 class="margen-imagen colortext1 boild" id="idset" style="color: #1a8dda;">PRODUCTOS</h1></center>



	<div class="card shadow-none">
		<div class="row margen-card profile_data_box">
	<?php
		$listProductos = array();
		$query_productos = $this->getDatabase()->Query("SELECT id_producto, po_nombre, po_nicho, po_precio, po_descripcion, po_linkvideo FROM t_producto where po_nicho=".$this->UserData->getPaisCodigoArea()->getIdPais());
		while ($data_producto = $this->getDatabase()->FetchArray($query_productos)) {
			array_push($listProductos, 
				new app\Producto(
					$data_producto["id_producto"],
					$data_producto["po_nombre"],
					$data_producto["po_nicho"],
					$data_producto["po_precio"],
					_DIR_."image_producto/200/".$data_producto["id_producto"],//$data_producto["po_foto"],
					$data_producto["po_descripcion"],
					$data_producto["po_linkvideo"]
				));}

		foreach ($listProductos as $producto) {
			$data_json = base64_encode(json_encode(array(
				"id" => $producto->getId(),
				"nombre" => $producto->getNombre(),
				"precio" => $producto->getPrecio(),
				"descripcion" => $producto->getDescripcion(),
				"image" => $producto->getFoto(),
				"url_video" => $producto->getLinkVideo()
			)));
	?>
			<div class="col " style=" margin-top: 2%;">
				<div class="card card_producto" style="width: 13rem; height: 100%">
					<center class="image_producto"><img src="<?php echo $producto->getFoto(); ?>" class="card-img-top" alt=""></center>
					<div class="card-body">
						<h5 class="card-title"><?php echo $producto->getNombre(); ?></h5>
						<label class="label-codigo" id="codigoproducto"><?php echo $producto->getId(); ?></label>
						<p class="card-text"><?php echo $producto->getDescripcion(); ?></p>
						<p class="card-text">$<?php echo $producto->getPrecio(); ?></p>
						<button class="btn btn-primary btn-block color-btn-card" onclick="dialogProducto('<?php echo $data_json;?>')">AñADIR AL CARRITO</button>
					</div>
				</div>
			</div>
	<?php
		}
	?>
		</div>
	</div>
</div>
<script type="text/javascript">
	function dialogProducto(data) {
		

			data = JSON.parse(window.atob(data));
			var nom = data.nombre;
			var dialog = new Dialog();
			dialog.setTitle("Nutrición")
			.setContent(`
			
			<div id="carousel__singup" class="carousel slide" data-ride="carousel" data-interval="false">
				<div class="carousel-inner">
					<div class="carousel-item active row">
						<div class="col-12 col-md-12 ">
							
				<div class="row">
					<div class="col ">
							<h5 class="card-title" id="txt_nom" >`+nom+`</h5>
							<center class="image_producto"><img src="`+data.image+`" class="card-img-top" alt=""></center>
							<center><label class="label-codigo" id="codigoproducto">`+data.id+`</label>
							<center><p class="card-text">`+data.descripcion+`</p></center>
							<center><p class="card-text">$`+data.precio+`</p></center>
					</div>
					<div class="col ">
						<iframe width="100%" src="`+data.url_video+`" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						<div class="form-group">
							<label class="label-cantidad">Cantidad:</label>
							<select class="form-control" id="exampleFormControlSelect1" onchange="new calcularcosto(`+data.precio+`)">
								<option >1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10</option>
							</select>
						</div>


						<center><h5 class="card-title" id="canti">$`+data.precio+`</h5></center>
						<button class="btn btn-primary btn-block color-btn-card" data-toggle="modal" data-target=".bd-example-modal-lg" id="btn_agregar_producto">comprar</button>
					</div>
				</div>
							
						</div>
					</div>
					<div class="carousel-item row">
						<div class="col-12 col-md-12 ">
						<label class="shadow-none" style="color:#2874A6; font-size:18px; " id="btn_volver">Volver</label>
							<div class="card-tablero__profil center-block" style=" margin-right:2.5%; margin-left:2.5%; margin-bottom:2.5%;">
						<div class="card-body">
						
						<p class="">Tipo de compra</p>
						
						<form style=" margin-bottom:2.5%;">
							    <label class="radio-inline" style="margin-right: 2.5%">
							      <input type="radio" id="rb1" name="optradio">Comprar para mi
							    </label>
							    <label class="radio-inline" style="margin-right: 2.5%">
							      <input type="radio" id="rb2" name="optradio">Comprar para regalo
							    </label>
							    <label class="radio-inline" style="margin-right: 2.5%">
							      <input type="radio" id="rb3" name="optradio">Comprar para donar
							    </label>
							</form>
						
						<div id="contencp"></div>
						
					</div>
					
					</div>
							
						</div>
					</div>
				</div>
			</div>

				
			`)
			.setOverlayClose(true).setCloseIconButton(true).setFullSize(true)
			.addHideEvent(function(){dialog.destroy();
				
			})
			.addClassDialogCard("producto_dialog").show();
			
			setTimeout(function() {
				
				$("#btn_agregar_producto").on('click',function(){if(comprobarCampos(0)){$("#carousel__singup").carousel('next');


			}});
				$("#btn_volver").on('click',function(){if(comprobarCampos(0)){$("#carousel__singup").carousel('prev');
						$("#contencp").html(" ");

			}});
				$("#rb1").on('click',function(){
						typecomprami(data.precio,data.id,data.nombre);

				});
				$("#rb2").on('click',function(){
						typecomprafa(data.precio,data.id,data.nombre);

				});
				$("#rb3").on('click',function(){
						typecomprado(data.precio,data.id,data.nombre);

				});
			}, 100);
		}

function calcularcosto(pre) {
  var x = $("#exampleFormControlSelect1").val();
  var mult= x*pre;
  var total= mult.toFixed(2);
  $("#canti").html("$ "+total);
}

function filtro() {
  var c_don = $("#select_controlc").val();
  var n_dep = $("#exampleFormControlSelect1").val();
 }
</script>


<script type="text/javascript">
function soloNumeros(e)
{
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57) || (key==8))
}
</script>



-------------------------------script carrusel----------------------------
<script type="text/javascript">
$(document).ready(function(){
		$("#btn__singup__next").on('click',function(){if(comprobarCampos(0)){$("#carousel__singup").carousel('next');}});
		$("#btn__singup__reg").on('click',function(){if(comprobarCampos(0)){$("#carousel__singup").carousel('next');}});
		});

function comprobarCampos(n){
		$("#w_singup").removeClass('error_show');
		if(n==0){
			var vcNombre	= "vamos";
			return vcNombre;
		}else if(n==1){/*
			var vcCorreo = $("#itext__correo").val().trim()!="" && validarEmail($("#itext__correo").val().trim());
			var vcPass = $("#itext__pass").val().length>=6 && $("#itext__pass").val()==$("#itext__re_pass").val();
			if(!(vcCorreo && vcPass)){
				$(".msg_error .msg").html("Complete los campos");
				$("#w_singup").addClass('error_show');
			}
			return vcCorreo && vcPass;*/
		}
		return false;
	}

</script>



<script type="text/javascript">

	
	function typecomprami(precio,cod,name){
		var x2 = $("#exampleFormControlSelect1").val();
		var x = precio*x2;
		var total= x.toFixed(2);

		$("#contencp").html(`
			<h3 class="bold">Detalle</h3>
			<div class="card-body center-block">
						<div class="row mab" style="margin-bottom:3.5%; height:5%;">
							<div class="col-5 bold" >Nombre:</div>
							<div class="col "><?php echo $this->UserData->getNombre()." ".$this->UserData->getApellido(); ?></div>
						</div>
						
						<div class="row mab" style="margin-top:3.5%; margin-bottom:3.5%; height:5%;">
							<div class="col-5 bold">Descripcion:</div>
							<div id="descriptp" class="col-7 "> `+x2+` del producto <strong>`+name+`</strong> con codigo numero : `+cod+`</div>
						</div>
						<div class="row mab" style="margin-top:3.5%; margin-bottom:3.5%; height:5%;">
							<div class="col-5 bold">Cantidad:</div>
							<div id="salidaprecio" class="col-7 ">$`+total+`</div>
						</div>

						<div class="row mab" style="margin-top:3.5%; margin-bottom:3.5%; height:5%;">
							<div class="col-5 bold">Direccion:</div>
							
							<div id="salidaprecio" class="col-7 ">
							<div class="row">
							<div class="col-8">

							<select class="form-control" id="iselect__pais">
							<?php echo $opciones_paises; ?>
							</select>

							</div>

							<div class="col-3">
							<button type="button" id="btn_agregar_direc1" class="btn btn-primary color-btn-card" style="width: 2%;">
							<span class="material-icons">add</span>
						</button>
							</div>



							</div>


							</div>


						</div>
						</div>
						<div class="row" >
					<div class="col-12 col-md-12">
						<button type="button" id="btn_comprarparami" class="btn btn-primary float-right color-btn-card">
							Proceder al pago
						</button>
					</div>
				</div>
			`)
		setTimeout(function() {
				$("#btn_comprarparami").on('click',function(){

					var dialogADDED = new Dialog();
						dialogADDED.setTitle("Proceder Al Pago")
								.setContent("Preciona continuar.")
								.setActions(['Cancelar','Continuar'])
								.setActionClick(0,function(){
									setTimeout(function() {
										dialogADDED.destroy();
										dialog.hide();


									}, 300);
								}).setActionClick(1,function(){
									setTimeout(function() {

								//window.open("<?php echo _DIR_.$this->GetUrl->ListViewsUrl[12]; ?>", "pago", "width=300, height=200");



						
						var combo = document.getElementById("iselect__pais");
						var Direccion = "Direccion: "+combo.options[combo.selectedIndex].text+ "";
						Util.post('<?php echo $this->GetUrl->ListViewsUrl[20]; ?>',{
							'comp_id_persona'			:	'<?php echo $this->UserData->getId(); ?>',
							'comp_id_transac'			:	"1",
							'comp_id_producto'			:	cod,
							'comp_c_cantidad'			:	x2,
							'comp_c_concepto'			:	Direccion,
							'comp_c_tipo'				:	1
						},function(data,status){
						var result = JSON.parse(data);
							if(typeof result.ERROR != "undefined"){
								alert("error");
							}else if(typeof result.REGISTERED != "undefined" && result.REGISTERED){
								alert("registrado anda a ver la db");
								window.location = '<?php echo _DIR_.$this->GetUrl->ListViewsUrl[18]; ?>';
							}
						});
						dialogADDED.destroy();
						dialog.hide();
									
									}, 300);
								}).show();

					

				});


				$("#btn_agregar_direc1").on('click',function(){

					var dialogADDED = new Dialog();
						dialogADDED.setTitle("AGREGAR DIRECCION")
								.setContent("Preciona continuar para agregar una direccion.")
								.setActions(['Cancelar','Continuar'])
								.setActionClick(0,function(){
									setTimeout(function() {
										dialogADDED.destroy();
										dialog.hide();


									}, 300);
								}).setActionClick(1,function(){
									setTimeout(function() {


								window.location = '<?php echo _DIR_.$this->GetUrl->ListViewsUrl[10]; ?>';
								dialogADDED.destroy();
										dialog.hide();		
									}, 300);
								}).show();

					

				});
				
			}, 100);

		;

		
	}

	

				






	function typecomprafa(precio,cod,name){

		var x2 = $("#exampleFormControlSelect1").val();
		var x = precio*x2;
		var total= x.toFixed(2);

		$("#contencp").html(`
			<h3 class="bold">Detalle</h3>
			<div class="card-body center-block">

						<div class="row mab" style=" margin-bottom:2.5%;">
							<div class="col-5 bold" >De:</div>
							<div class="col "><?php echo $this->UserData->getNombre()." ".$this->UserData->getApellido(); ?></div>
						</div>

						<div class="row mab" style="margin-top:2.5%; margin-bottom:2.5%;">
							<div class="col-5 bold" >Para:</div>
							<div class="col "><input type="text" class="form-control" id="cr_txt_nombre" placeholder="Nombre y Apellido"></div>
						</div>
						<div class="row mab" style="margin-top:2.5%; margin-bottom:2.5%;">
							<div class="col-5 bold" >Telefono:</div>
							<div class="col "><input class="form-control" id="cr_txt_tel" placeholder="Telefono" type="text" onKeyPress="return soloNumeros(event)"></div>
						</div>
						
						<div class="row mab" style="margin-top:3.5%; margin-bottom:3.5%; height:5%;">
							<div class="col-5 bold" >Direccion</div>
							<div class="col ">

							<div class="row">
							<div class="col-8">

							<select class="form-control" id="iselect__paisfa" >
							<?php echo $opciones_paises2; ?>
							</select>

							</div>

							<div class="col-3">
							<button type="button" class="btn btn-primary color-btn-card" style="width: 2%;" id="btn_agregar_direc2">
							<span class="material-icons">add</span>
						</button>
							</div>
							</div>
							</div>
						</div>
						<div class="row mab" style="margin-top:3.5%; margin-bottom:3.5%; height:5%;">
							<div class="col-5 bold">Descripcion:</div>
							<div id="descriptp" class="col-7 "> `+x2+` del producto <strong>`+name+`</strong> con codigo numero : `+cod+`</div>
						</div>
						<div class="row mab">
							<div class="col-5 bold">Cantidad:</div>
							<div id="salidaprecio" class="col-7 ">$`+total+`</div>
						</div>

						
						</div>

					</div>

					<div class="row">
					<div class="col-12 col-md-12">
						<button type="button" id="btn_comprarparafa" class="btn btn-primary float-right color-btn-card">
							Proceder al pago
						</button>
					</div>
				</div>
			`)
		setTimeout(function() {
				$("#btn_comprarparafa").on('click',function(){

					if ($("#cr_txt_nombre").val().trim()!=""&&$("#cr_txt_tel").val().trim()!="") {

						var dialogADDED = new Dialog();
						dialogADDED.setTitle("Proceder Al Pago")
								.setContent("Preciona continuar.")
								.setActions(['Cancelar','Continuar'])
								.setActionClick(0,function(){
									setTimeout(function() {
										dialogADDED.destroy();
										dialog.hide();


									}, 300);
								}).setActionClick(1,function(){
									setTimeout(function() {


											var combo = document.getElementById("iselect__paisfa");
						var Direccion = "Direccion: "+combo.options[combo.selectedIndex].text+ "";
						
						
						Util.post('<?php echo $this->GetUrl->ListViewsUrl[20]; ?>',{
							'comp_id_persona'			:	'<?php echo $this->UserData->getId(); ?>',
							'comp_id_transac'			:	"1",
							'comp_id_producto'			:	cod,
							'comp_c_cantidad'			:	x2,
							'comp_c_concepto'			:	Direccion,
							'comp_c_tipo'				:	2
				},function(data,status){
						var result = JSON.parse(data);
							if(typeof result.ERROR != "undefined"){
								alert("error");
							}else if(typeof result.REGISTERED != "undefined" && result.REGISTERED){
								alert("registrado anda a ver la db");
								window.location = '<?php echo _DIR_.$this->GetUrl->ListViewsUrl[18]; ?>';
							}

				});

						dialogADDED.destroy();
						dialog.hide();
										
									}, 300);
								}).show();

					

					}else{
						var dialogADDED = new Dialog();
						dialogADDED.setTitle("COMPLETE LOS CAMPOS")
								.setContent("")
								.setActions(['OK'])
								.setActionClick(0,function(){
									setTimeout(function() {
										
										dialogADDED.hide();
										dialogADDED.destroy();


									}, 300);
								}).show();


					}

					

				});


				$("#btn_agregar_direc2").on('click',function(){

					var dialogADDED = new Dialog();
						dialogADDED.setTitle("AGREGAR DIRECCION")
								.setContent("Preciona continuar para agregar una direccion.")
								.setActions(['Cancelar','Continuar'])
								.setActionClick(0,function(){
									setTimeout(function() {
										dialogADDED.destroy();
										dialog.hide();


									}, 300);
								}).setActionClick(1,function(){
									setTimeout(function() {


								window.location = '<?php echo _DIR_.$this->GetUrl->ListViewsUrl[10]; ?>';
								dialogADDED.destroy();
										dialog.hide();		
									}, 300);
								}).show();

					

				});
				
			}, 100);


		;
	}




	function typecomprado(precio,cod,name){
		var x2 = $("#exampleFormControlSelect1").val();
		var x = precio*x2;
		var total= x.toFixed(2);
	
		$("#contencp").html(`
			<h3 class="bold">Detalle</h3>
			<div class="card-body center-block">
						<div class="row " style=" margin-bottom:2.5%;">
							<div class="col-5 bold" >Nombre:</div>
							<div class="col "><?php echo $this->UserData->getNombre()." ".$this->UserData->getApellido(); ?></div>
						</div>
						
						<div class="row " style="margin-top:5%; margin-bottom:5%;">
							<div class="col-5 bold">Donacion a:</div>
							<div class="col ">
							<select class="form-control" id="id_cbx_diri">
								 
								  <option>El Salvador</option>
							      <option>Ahuachapán</option>
							      <option>Cabañas</option>
							      <option>Chalatenango</option>
							      <option>Cuscatlán</option>
							      <option>La Libertad</option>
							      <option>La Paz</option>
							      <option>La Unión</option>
							      <option>Morazán</option>
							      <option>San Miguel</option>
							      <option>San Salvador</option>
							      <option>San Vicente</option>
							      <option>Santa Ana</option>
							      <option>Sonsonate</option>
							      <option>Usulután</option>
							      <option>Otro:</option>
							  </select>

							</div>
						</div>

						<div class="row " style="margin-bottom:2%;">
							<div class="col-5 bold">Especificaciones:</div>
							<div class="col "> 
							<textarea class="form-control" id="id_ta_especifi" rows="3">.</textarea>    
							</div>
						</div>
						
						<div class="row " style="margin-bottom:2%;">
							<div class="col-5 bold">Descripcion:</div>
							<div id="descriptp" class="col "> `+x2+` del producto <strong>`+name+`</strong> con codigo numero : `+cod+`</div>
						</div>
						<div class="row " style="margin-bottom:2%;">
							<div class="col-5 bold">Cantidad:</div>
							<div id="salidaprecio" class="col ">$`+total+`</div>
						</div>

						
							Dona el producto que deseas para ayudar a los salvadoreños unete a los tuyos.
						




						</div>
								
						
					</div>

					<div class="row">
					<div class="col-12 col-md-12">
						<button type="button" id="btn_comprarparado" class="btn btn-primary float-right color-btn-card">
							Proceder al pago
						</button>
					</div>
				</div>
			`);
				setTimeout(function() {
				$("#btn_comprarparado").on('click',function(){

					if ($("#id_ta_especifi").val().trim()!="") {

						var dialogADDED = new Dialog();
						dialogADDED.setTitle("Proceder Al Pago")
								.setContent("Preciona continuar.")
								.setActions(['Cancelar','Continuar'])
								.setActionClick(0,function(){
									setTimeout(function() {
										dialogADDED.destroy();
										dialog.hide();


									}, 300);
								}).setActionClick(1,function(){
									setTimeout(function() {


											var combo = document.getElementById("id_cbx_diri");
						var Direccion = "Direccion: "+combo.options[combo.selectedIndex].text+ " " +$("#id_ta_especifi").val().trim();
						
						
						Util.post('<?php echo $this->GetUrl->ListViewsUrl[20]; ?>',{
							'comp_id_persona'			:	'<?php echo $this->UserData->getId(); ?>',
							'comp_id_transac'			:	"1",
							'comp_id_producto'			:	cod,
							'comp_c_cantidad'			:	x2,
							'comp_c_concepto'			:	Direccion,
							'comp_c_tipo'				:	3
				},function(data,status){
						var result = JSON.parse(data);
							if(typeof result.ERROR != "undefined"){
								alert("error");
							}else if(typeof result.REGISTERED != "undefined" && result.REGISTERED){
								alert("registrado anda a ver la db");
								window.location = '<?php echo _DIR_.$this->GetUrl->ListViewsUrl[18]; ?>';
							}

				});

						dialogADDED.destroy();
						dialog.hide();
										
									}, 300);
								}).show();

					

					}else{
						var dialogADDED = new Dialog();
						dialogADDED.setTitle("COMPLETE LOS CAMPOS")
								.setContent("")
								.setActions(['OK'])
								.setActionClick(0,function(){
									setTimeout(function() {
										
										dialogADDED.hide();
										dialogADDED.destroy();


									}, 300);
								}).show();


					}

					

				});


				
				
			}, 100);

	}




</script>

