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
<section id="view_facturar_new">
	<div class="title__page"><i class="material-icons mr-3">shopping_basket</i> Nueva factura</div>

	<div class="card addedbox custom-color custom-color-dark" id="productoSeleccionBox" style="display: none; background-color: #d40058;">
		<div class="card-body">
			<div class="row title__productos" style="background-color: transparent;">
				<div class="col" style="max-width: 100%;">Producto seleccionado</div>
			</div>
			<div class="row title__productos" style="background-color: rgba(0, 0, 0, 0.05);">
				<div class="col" style="max-width: 100px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col" style="max-width: 150px;">Categoria</div>
				<div class="col" style="max-width: 150px;">Proveedor</div>
				<div class="col" style="max-width: 150px;">Cantidad Existencia</div>
				<div class="col" style="max-width: 150px;">Cantidad</div>
				<div class="col" style="max-width: 150px;">Precio total</div>
			</div>
		</div>
		<div class="card-body" id="productoSeleccion"></div>
		<div class="card-body">
			<div class="row row-actions">
				<div class="col  d-flex flex-row-reverse">
					<button type="button" class="btn btn-primary color-btn-card" id="btn__add_pro">
						<span class="material-icons">add</span>
						Agregar producto
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="card addedbox custom-color custom-color-dark" style="background-color: #30BBD1">
		<div class="card-body">
			<div class="row title__productos" style="background-color: transparent;">
				<div class="col" style="max-width: 100%;">Buscar producto</div>
			</div>
			<div class="row title__productos">
				<div class="col" style="max-width: 100px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col" style="max-width: 150px;">Categoria</div>
				<div class="col" style="max-width: 150px;">Proveedor</div>
			</div>
			<div class="row">
				<div class="col" style="max-width: 100px;">
					<div class="form-group">
						<input type="text" class="form-control" id="txt_cod_pro" data-mask="00000" maxlength="5" placeholder="Codigo">
					</div>
				</div>
				<div class="col" style="max-width: 100%;">
					<div class="form-group">
						<input type="text" class="form-control" id="txt_nombre_pro" placeholder="Nombre">
					</div>
				</div>
				<div class="col" style="max-width: 150px;">
					<div class="form-group">
						<select class="form-control" name="categoria" id="select__categoria">
							<option value="">Todas</option>
							<?php echo $listCategoriasOption; ?>
						</select>
					</div>
				</div>
				<div class="col" style="max-width: 150px;">
					<div class="form-group">
						<select class="form-control" name="proveedor" id="select__proveedor">
							<option value="">Todos</option>
							<?php echo $listProveedoresOption; ?>
						</select>
					</div>
				</div>
			</div>
			<!--<div class="row">
				<div class="col d-flex flex-row-reverse">
					<button type="button" class="btn btn-primary color-btn-card" id="btn__add_pro">
						<span class="material-icons">add</span>
						Agregar producto
					</button>
				</div>
			</div>-->
			<div class="row title__productos titleListProductos" style="background-color: transparent;">
				<div class="col" style="max-width: 100%;">Lista de productos</div>
			</div>
			<div class="row title__productos titleListProductos">
				<div class="col" style="max-width: 100px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col" style="max-width: 100px;">Marca</div>
				<div class="col" style="max-width: 100px;">Modelo</div>
				<div class="col" style="max-width: 100px;">Existencia</div>
				<div class="col" style="max-width: 150px;">Precio Unitario</div>
			</div>
		</div>
		<div class="card-body" id="listViewProductoSeleccion"></div>
	</div>

	<div class="card custom-color custom-color-dark" style="background-color: #00d48f">
		<div class="card-body">
			<!--<h5 class="card-title"><span class="material-icons">assignment</span> Lista de proveedores</h5>-->

			<div class="row title__productos" style="background-color: transparent">
				<div class="col">Productos a comprar</div>
			</div>

			<div class="row title__productos">
				<div class="col" style="max-width: 60px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col" style="max-width: 90px;">Marca</div>
				<div class="col" style="max-width: 90px;">Modelo</div>
				<div class="col" style="max-width: 90px;">Cantidad</div>
				<div class="col" style="max-width: 70px;">Precio Unitario</div>
				<div class="col" style="max-width: 150px;">Pre</div>
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
	var dataProductos;
	var productoSeleccionado;
	function getProducto(id){
		for (var i = 0; i < dataProductos.length; i++) {
			if(dataProductos[i].id == id){
				return dataProductos[i];
			}
		}
	}
	/*var dataProductos = {
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
	}*/

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
	function eventKeyDownCantidad(e){
		//var root = this;
		//console.log(e.key);
		//console.log(e.which);
		var txt = $("#txt_cant_pro").val();
		//console.log(txt.split(".").length==2 ? txt.split(".")[1].length<=2 : true);
		if(!(
			(!isNaN(parseInt(e.key)) && parseInt(e.key)>=0 && parseInt(e.key)<=9) || 
			e.key=="Backspace"  || e.key=="Delete"  || e.key=="Enter"  || 
			e.key=="Control"  || e.key=="Alt"  || e.key=="AltGraph" || 
			e.key=="ArrowLeft" || e.key=="ArrowRight" || e.key=="ArrowUp" || 
			e.key=="ArrowDown" || e.key=="Tab" || e.key=="Shift"
			//txt<=$("#txt_cant_pro").attr("max")
		)){
			e.preventDefault();
		}
		setTimeout(function() {
			/*if($("#txt_cant_pro").val()>){
				$("#txt_cant_pro").val(1);
			}*/
		}, 5);
		eventChangeCantidad();
	}
	function eventChangeCantidad(){
		console.log("hola");
		setTimeout(function() {
			var cant = $("#txt_cant_pro").val().length==0 ? 0 : $("#txt_cant_pro").val();
			$("#labelPrecioTotal").html("$"+(parseFloat(cant)*parseFloat(productoSeleccionado.precio)));
		}, 10);
	}

	function selecionarProducto(id){
		productoSeleccionado = getProducto(id);
		$("#productoSeleccion *").remove();
		$("#productoSeleccion").html(`
			<div class="row">
				<div class="col" style="max-width: 100px;">`+productoSeleccionado.id+`</div>
				<div class="col" style="max-width: 100%;">`+productoSeleccionado.nombre+`</div>
				<div class="col" style="max-width: 150px;">`+productoSeleccionado.categoria.nombre+`</div>
				<div class="col" style="max-width: 150px;">`+productoSeleccionado.proveedor.nombre+`</div>
				<div class="col" style="max-width: 150px;">`+productoSeleccionado.cantidad_existencia+`</div>
				<div class="col" style="max-width: 150px;"><div class="form-group"><input type="text" class="form-control" id="txt_cant_pro" data-mask-as-number-min="1" data-mask-as-number-max="`+productoSeleccionado.cantidad_existencia+`" value="1" placeholder="Cantidad"></div></div>
				<div class="col" style="max-width: 150px;" id="labelPrecioTotal">$`+productoSeleccionado.precio+`</div>
			</div>
		`);
		$("#productoSeleccionBox").css("display",'');
		setTimeout(function() {
			$("#txt_cant_pro").maskAsNumber();
			$("#txt_cant_pro").keydown(eventChangeCantidad);
			//$("#txt_cant_pro").keydown(eventKeyDownCantidad);
		}, 10);

	}

	function searchProducto(){
		Util.post('productos/get',
			{
				'nombre':$("#txt_nombre_pro").val().trim(),
				'categoria':$("#select__categoria").val(),
				'proveedor':$("#select__proveedor").val()
			},
			function(resp,status){
				var dataResp = JSON.parse(resp);
				dataProductos = dataResp;
				if(typeof dataResp.ERROR=='undefined'){
					$("#listViewProductoSeleccion").html("");
					dataResp.forEach(function(e){
						$("#listViewProductoSeleccion").append(`
							<div class="row" data-producto-id="`+e.id+`">
								<div class="col" style="max-width: 100px;">`+e.id+`</div>
								<div class="col" style="max-width: 100%;">`+e.nombre+`</div>
								<div class="col" style="max-width: 100px;">`+e.marca+`</div>
								<div class="col" style="max-width: 100px;">`+e.modelo+`</div>
								<div class="col" style="max-width: 100px;">`+e.cantidad_existencia+`</div>
								<div class="col" style="max-width: 150px;">`+e.precio+`</div>
							</div>
						`);
					});
					$(".titleListProductos").css('display',dataResp.length==0 ? 'none' : '');
					$("#listViewProductoSeleccion .row").click(function(){selecionarProducto($(this).attr("data-producto-id"))});
				}
			});
	}
	$(document).ready(function(){
		$("#txt_nombre_pro").keydown(function(e){
			setTimeout(function() {
				searchProducto();
			}, 10);
		});
		$("#select__categoria,#select__proveedor").change(function(){
			setTimeout(function() {
				searchProducto();
			}, 10);
		});
		$("#txt_nombre_pro").keydown();
	});
</script>