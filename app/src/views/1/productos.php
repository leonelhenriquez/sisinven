<?php

$query_productos = $this->getDatabase()->Query(sprintf(
	"SELECT p.id_producto, p.nombre, p.marca, p.modelo, 
			p.cantidad_existencia, p.descripcion, p.precio, 
			p.categoria, c.nombre AS nombrecat, 
			p.proveedor, prov.nombre AS nombreprov 
	FROM productos AS p 
	JOIN categorias AS c ON c.id_categoria=p.categoria 
	JOIN proveedor AS prov ON prov.id_proveedor=p.proveedor 
	WHERE p.removed=0 AND p.empresa = '%d'",
	$this->UserData->getEmpresa()));
$listProductos = array();
while ($pro = $this->getDatabase()->FetchArray($query_productos)) {
	array_push($listProductos, 
		(new app\Producto())
		->setId($pro['id_producto'])
		->setNombre($pro['nombre'])
		->setCategoria($pro['categoria'],$pro['nombrecat'])
		->setMarca($pro['marca'])
		->setModelo($pro['modelo'])
		->setCantidadExistencia($pro['cantidad_existencia'])
		->setDescripcion($pro['descripcion'])
		->setPrecio($pro['precio'])
		->setProveedor($pro['proveedor'],$pro['nombreprov']));
}


$query_categorias = $this->getDatabase()->Query(sprintf(
	"SELECT id_categoria, nombre FROM categorias WHERE empresa = '%d'",
	$this->UserData->getEmpresa()
));
$listCategorias = array();
$listCategoriasOption = "";
while ($cat = $this->getDatabase()->FetchArray($query_categorias)) {
	$catObj = (new app\Categoria())->setId($cat['id_categoria'])->setNombre($cat['nombre']);
	array_push($listCategorias, $catObj);
	$listCategoriasOption .= sprintf('<option value="%d">%s</option>',$catObj->getId(),$catObj->getNombre())."\n";
}


$query_proveedores = $this->getDatabase()->Query(sprintf(
	"SELECT id_proveedor, nombre FROM proveedor WHERE empresa = '%d'",
	$this->UserData->getEmpresa()
));
$listProveedores = array();
$listProveedoresOption = "";
while ($prov = $this->getDatabase()->FetchArray($query_proveedores)) {
	$provObj = (new app\Proveedor())->setIdProveedor($prov['id_proveedor'])->setNombreProveedor($prov['nombre']);
	array_push($listProveedores, $provObj);
	$listProveedoresOption .= sprintf('<option value="%d">%s</option>',$provObj->getIdProveedor(),$provObj->getNombreProveedor())."\n";
}
?>
<section id="view_productos">
	<div class="title__page"><i class="material-icons mr-3">shopping_basket</i> Productos</div>

	<div class="card btn_actions">
		<div class="card-body">
			
			<div class="row">
				<div class="col d-flex flex-row-reverse col__buttons">
					<button type="button" class="btn btn-primary color-btn-card" id="btn__add_pro">
						<span class="material-icons">add</span>
						Agregar producto
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-body">
			<!--<h5 class="card-title"><span class="material-icons">assignment</span> Lista de proveedores</h5>-->

			<div class="row title__productos">
				<div class="col" style="max-width: 60px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col" style="max-width: 90px;">Marca</div>
				<div class="col" style="max-width: 90px;">Modelo</div>
				<div class="col" style="max-width: 90px;">Cantidad</div>
				<div class="col" style="max-width: 70px;">Precio</div>
				<div class="col" style="max-width: 150px;">Categoria</div>
				<div class="col" style="max-width: 250px;display: none;">Descripción</div>
				<div class="col" style="max-width: 100px;">Proveedor</div>
				<div class="col" style="max-width: 98px;margin-right: -6px;" style="border-color: transparent">&nbsp;</div>
			</div>
	<?php
		foreach ($listProductos as $pro) {
	?>
			
			<div class="row" id="<?php echo "pro__".$pro->getId(); ?>">
				<div class="col" style="max-width: 60px;"><?php echo $pro->getId(); ?></div>
				<div class="col" style="max-width: 100%;"><?php echo $pro->getNombre(); ?></div>
				<div class="col" style="max-width: 90px;"><?php echo $pro->getMarca(); ?></div>
				<div class="col" style="max-width: 90px;"><?php echo $pro->getModelo(); ?></div>
				<div class="col" style="max-width: 90px;"><?php echo $pro->getCantidadExistencia(); ?></div>
				<div class="col" style="max-width: 70px;">$<?php echo $pro->getPrecio(); ?></div>
				<div class="col" style="max-width: 150px;"><?php echo $pro->getCategoria()->getNombre(); ?></div>
				<div class="col" style="max-width: 250px; display: none;"><?php echo $pro->getDescripcion(); ?></div>
				<div class="col" style="max-width: 100px;"><?php echo $pro->getProveedor()->getNombreProveedor(); ?></div>
				<div class="col col__buttons" style="max-width: 98px; margin: 0px -6px 0px auto;">
					<div class="btn-group">
						<button type="button" class="btn btn__option btn-primary color-btn-card btn-sm" onclick="view(<?php echo (int)$pro->getId(); ?>)">
							<span class="material-icons">visibility</span>
						</button>
						<button type="button" class="btn btn__option btn-primary color-btn-card btn-sm" onclick="edit(<?php echo (int)$pro->getId(); ?>)">
							<span class="material-icons">edit</span>
						</button>
						<button type="button" class="btn btn__option btn-primary color-btn-card btn-sm" onclick="remove('<?php echo $pro->getId(); ?>')">
							<span class="material-icons">delete</span>
						</button>
					</div>
				</div>
			</div>
	<?php
		} 
	?>
			<div class="row">
				<!--<div class="col d-flex flex-row-reverse">
					<button type="button" class="btn btn-primary color-btn-card" id="btn__add_pro">
						<span class="material-icons">add</span>
						Agregar producto
					</button>
				</div>-->
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	
	var dataProductos = {
	<?php
		foreach ($listProductos as $pro) {
	?>
		<?php echo (int)$pro->getId(); ?>:{
			'id'			: '<?php echo $pro->getId(); ?>' ,
			'nombre'		: '<?php echo $pro->getNombre(); ?>' ,
			'marca'			: '<?php echo $pro->getMarca(); ?>' ,
			'modelo'		: '<?php echo $pro->getModelo(); ?>' ,
			'cantidad'		: '<?php echo $pro->getCantidadExistencia(); ?>',
			'precio'		: '<?php echo $pro->getPrecio(); ?>' ,
			'descripcion'	: '<?php echo $pro->getDescripcion(); ?>' ,
			'proveedor'		: '<?php echo $pro->getProveedor()->getIdProveedor(); ?>' ,
			'categoria'		: '<?php echo $pro->getCategoria()->getId(); ?>' 
		},
	<?php
		} 
	?>
	}


	$("#btn__add_pro").click(function() {
		var dialog = new Dialog();
		dialog.setTitle("Agregar producto")
		.addClassDialogCard("dialog__producto")
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
						<label for="itext__nom_pro">Nombre del producto:</label>
						<input type="text" class="form-control" id="itext__nom_pro" name="nombre" placeholder="Nombre del producto">
						<small id="small_itext__nom_pro" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__marca">Marca:</label>
						<input type="text" class="form-control" id="itext__marca" name="marca" placeholder="Marca">
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__modelo">Modelo:</label>
						<input type="text" class="form-control" id="itext__modelo" name="modelo" placeholder="Modelo">
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__cantidad">Cantidad:</label>
						<input type="text" class="form-control" id="itext__cantidad" data-mask="00000000000" name="cantidad" placeholder="Cantidad">
						<small id="small_itext__cantidad" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__precio">Precio:</label>
						<input type="text" class="form-control" id="itext__precio" name="precio" placeholder="Precio">
						<small id="small_itext__precio" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__descrip">Descripción:</label>
						<textarea type="text" class="form-control" id="itext__descrip" name="descripcion" placeholder="Descripción"></textarea>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="select__proveedor">Proveedor</label>
						<select class="form-control" name="proveedor" id="select__proveedor">
							<?php echo $listProveedoresOption; ?>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="select__categoria">Categoria</label>
						<select class="form-control" name="categoria" id="select__categoria">
							<?php echo $listCategoriasOption; ?>
						</select>
					</div>
				</div>
			</div>
		`)
		.setActions(["Cerrar","Agregar"])
		.setActionClick(0,function(){
			dialog.hide();
		})
		.setActionClick(1,function(){
			var data = {
				'nombre'		:$("#itext__nom_pro").val().trim(),
				'marca'			:$("#itext__marca").val().trim(),
				'modelo'		:$("#itext__modelo").val().trim(),
				'cantidad'		:$("#itext__cantidad").val().trim(),
				'precio'		:$("#itext__precio").val().trim(),
				'descripcion'	:$("#itext__descrip").val().trim(),
				'proveedor'		:$("#select__proveedor").val().trim(),
				'categoria'		:$("#select__categoria").val().trim()
			}
			if(data.nombre!='' && data.cantidad>=0 && data.precio>=0 && data.proveedor>0 && data.categoria>0){
				dialog.removeClassDialogCard("error_show");
				$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",true);
				Util.post('/productos/add',data,
					function(resp,status){
						var showError = false;
						$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",false);
						try{
							var result = JSON.parse(resp);
							if(typeof result.ADDED != "undefined"){
								if(result.ADDED){
									window.location = '<?php echo _DIR_."productos"; ?>';
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
					}
				);
			}else{
				$("#"+dialog.getId()+" .msg_error .msg").html("Algunos campos no pueden quedar vaciones (Nombrem, Cantidad, Precio).");
				dialog.addClassDialogCard("error_show");
			}
		})
		.addHideEvent(function(){
			dialog.destroy();
		})
		.setFullSize(true).show();
		setTimeout(function() {
			$("#itext__precio").keydown(keyFloatEvent);
			$("#itext__nom_pro").keydown(function(e){
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
	function remove(id){
		Util.post('/productos/remove',{'id':id},function(resp,status){
			var result = JSON.parse(resp);
			if(result.REMOVED){
				$("#pro__"+id).remove();
			}else{
				(new ErrorDialog()).setTextError("No se pudo eliminar el producto.").show();
			}
		});
	}

	function edit(id){
		var dataProducto = dataProductos[id];
		console.log(dataProducto)
		var dialog = new Dialog();
		dialog.setTitle("Editar producto")
		.addClassDialogCard("dialog__producto")
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
						<label for="itext__nom_pro">Nombre del producto:</label>
						<input type="text" class="form-control" id="itext__nom_pro" name="nombre" placeholder="Nombre del producto" value="`+dataProducto.nombre+`">
						<small id="small_itext__nom_pro" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__marca">Marca:</label>
						<input type="text" class="form-control" id="itext__marca" name="marca" placeholder="Marca" value="`+dataProducto.marca+`">
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__modelo">Modelo:</label>
						<input type="text" class="form-control" id="itext__modelo" name="modelo" placeholder="Modelo" value="`+dataProducto.modelo+`">
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__cantidad">Cantidad:</label>
						<input type="text" class="form-control" id="itext__cantidad" name="cantidad" placeholder="Cantidad" value="`+dataProducto.cantidad+`">
						<small id="small_itext__cantidad" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__precio">Precio:</label>
						<input type="text" class="form-control input-float" id="itext__precio" name="precio" placeholder="Precio" value="`+dataProducto.precio+`">
						<small id="small_itext__precio" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>

				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__descrip">Descripción:</label>
						<textarea type="text" class="form-control" id="itext__descrip" name="descripcion" placeholder="Descripción">`+dataProducto.descripcion+`</textarea>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="select__proveedor">Proveedor</label>
						<select class="form-control" name="proveedor" id="select__proveedor">
							<?php echo $listProveedoresOption; ?>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="select__categoria">Categoria</label>
						<select class="form-control" name="categoria" id="select__categoria">
							<?php echo $listCategoriasOption; ?>
						</select>
					</div>
				</div>
			</div>
		`)
		.setActions(["Cerrar","Guardar"])
		.setActionClick(0,function(){
			dialog.hide();
		})
		.setActionClick(1,function(){
			var data = {
				'id'			: dataProducto.id,
				'nombre'		: $("#itext__nom_pro").val().trim(),
				'marca'			: $("#itext__marca").val().trim(),
				'modelo'		: $("#itext__modelo").val().trim(),
				'cantidad'		: $("#itext__cantidad").val().trim(),
				'precio'		: parseFloat($("#itext__precio").val().replace(/ /g,'')),
				'descripcion'	: $("#itext__descrip").val().trim(),
				'proveedor'		: $("#select__proveedor").val().trim(),
				'categoria'		: $("#select__categoria").val().trim()
			}
			if(data.nombre!='' && data.cantidad>=0 && data.precio>=0 && data.proveedor>0 && data.categoria>0){
				dialog.removeClassDialogCard("error_show");
				$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",true);
				Util.post('/productos/update',data,
					function(resp,status){
						var showError = false;
						$("#"+dialog.getId()+" input, #"+dialog.getId()+" button").prop("disabled",false);
						try{
							var result = JSON.parse(resp);
							if(typeof result.ADDED != "undefined"){
								if(result.ADDED){
									window.location = '<?php echo _DIR_."productos"; ?>';
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
					}
				);
			}
		})
		.addHideEvent(function(){
			dialog.destroy();
		})
		.setFullSize(true).show();
		setTimeout(function() {
			$("#select__proveedor").val(dataProducto.proveedor);
			$("#select__categoria").val(dataProducto.categoria);
			$("#itext__cantidad").mask('0#');
			$("#itext__precio").keydown(keyFloatEvent);
			$("#itext__nom_pro").keydown(function(e){
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






	function view(id){
		var dataProducto = dataProductos[id];
		console.log(dataProducto)
		var dialog = new Dialog();
		dialog.setTitle("Producto")
		.addClassDialogCard("dialog__producto")
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
						<label for="itext__nom_pro">Nombre del producto:</label>
						<input type="text" class="form-control" id="itext__nom_pro" disabled name="nombre" placeholder="Nombre del producto" value="`+dataProducto.nombre+`">
						<small id="small_itext__nom_pro" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__marca">Marca:</label>
						<input type="text" class="form-control" id="itext__marca" disabled name="marca" placeholder="Marca" value="`+dataProducto.marca+`">
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__modelo">Modelo:</label>
						<input type="text" class="form-control" id="itext__modelo" disabled name="modelo" placeholder="Modelo" value="`+dataProducto.modelo+`">
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__cantidad">Cantidad:</label>
						<input type="text" class="form-control" id="itext__cantidad" disabled name="cantidad" placeholder="Cantidad" value="`+dataProducto.cantidad+`">
						<small id="small_itext__cantidad" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__precio">Precio:</label>
						<input type="text" class="form-control input-float" id="itext__precio" disabled name="precio" placeholder="Precio" value="`+dataProducto.precio+`">
						<small id="small_itext__precio" class="form-text text-muted error__input">Error el campo esta vacio.</small>
					</div>
				</div>

				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="itext__descrip">Descripción:</label>
						<textarea type="text" class="form-control" id="itext__descrip" disabled name="descripcion" placeholder="Descripción">`+dataProducto.descripcion+`</textarea>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="select__proveedor">Proveedor</label>
						<select class="form-control" name="proveedor" disabled id="select__proveedor">
							<?php echo $listProveedoresOption; ?>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-12">
					<div class="form-group">
						<label for="select__categoria">Categoria</label>
						<select class="form-control" name="categoria" disabled id="select__categoria">
							<?php echo $listCategoriasOption; ?>
						</select>
					</div>
				</div>
			</div>
		`)
		.setActions(["Cerrar"])
		.setActionClick(0,function(){
			dialog.hide();
		})
		.addHideEvent(function(){
			dialog.destroy();
		})
		.setFullSize(true).setCloseIconButton(true).show();
		setTimeout(function() {
			$("#select__proveedor").val(dataProducto.proveedor);
			$("#select__categoria").val(dataProducto.categoria);
			$("#itext__cantidad").mask('0#');
		}, 100);

	}
</script>