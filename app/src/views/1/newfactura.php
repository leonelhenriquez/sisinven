<?php

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
	<div class="title__page" style="display: none;"><i class="material-icons mr-3">shopping_basket</i> Nueva factura</div>



	<div class="card card-compra-info custom-color custom-color-dark" style=" background-color: #4caf50;">
		<div class="card-body">
			<div class="row info-compra">
				<div class="col label-total">Total a pagar:</div>
				<div class="col total-money">$0.00</div>
			</div>
			<div class="info-compra-input">
				<div class="col" style="max-width:100%">Nombre cliente</div>
				<div class="col" style="max-width:100%">
					<div class="form-group">
						<input type="text" class="form-control" id="txt_nombre_cliente" maxlength="60" placeholder="Nombre del cliente">
					</div>
				</div>
			</div>
			<div class="row row-actions" id="rowActionsFactura" style="display: none">
				<div class="col  d-flex flex-row-reverse">
					<button type="button" class="btn btn-primary color-btn-card" id="btn__finalizar_compra">
						<span class="material-icons">shopping_cart</span>
						Finalizar compra
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
				<div class="col" style="max-width: 80px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col" style="max-width: 150px;">Categoria</div>
				<div class="col" style="max-width: 150px;">Proveedor</div>
			</div>
			<div class="row">
				<div class="col" style="max-width: 80px;">
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
			<div class="row title__productos titleListProductos" style="background-color: transparent;">
				<div class="col" style="max-width: 100%;">Lista de productos</div>
			</div>
			<div class="row title__productos titleListProductos">
				<div class="col" style="max-width: 80px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col hidden-movil" style="max-width: 100px;">Marca</div>
				<div class="col hidden-movil" style="max-width: 100px;">Modelo</div>
				<div class="col" style="max-width: 100px;">Existencia</div>
				<div class="col" style="max-width: 150px;">Precio Unitario</div>
			</div>
		</div>
		<div class="card-body efect-hover" id="listViewProductoSeleccion"></div>
		<div class="card-body" style="display: none;">
			<div class="row row-actions">
				<div class="col  d-flex flex-row-reverse">
					<nav class="pagination-nav">
						<ul class="pagination">
							<li class="page-item"><a class="page-link page-link-icon material-icons" href="#">navigate_before</a></li>
							<li class="page-item"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item"><a class="page-link page-link-icon material-icons" href="#">navigate_next</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div class="card addedbox custom-color custom-color-dark" id="productoSeleccionBox" style=" background-color: #d40058;">
		<div class="card-body">
			<div class="row title__productos" style="background-color: transparent;">
				<div class="col" style="max-width: 100%;">Productos a comprar</div>
			</div>
			<div class="row title__productos" style="background-color: rgba(0, 0, 0, 0.05);">
				<div class="col" style="max-width: 80px;">Codigo</div>
				<div class="col" style="max-width: 100%;">Nombre</div>
				<div class="col hidden-movil" style="max-width: 90px;">Marca</div>
				<div class="col hidden-movil" style="max-width: 90px;">Modelo</div>
				<div class="col hidden-movil" style="max-width: 100px;">Categoria</div>
				<div class="col hidden-movil" style="max-width: 100px;">Proveedor</div>
				<div class="col hidden-movil" style="max-width: 100px;">Cantidad Existencia</div>
				<div class="col" style="max-width: 100px;">Cantidad</div>
				<div class="col" style="max-width: 100px;">Precio Unitario</div>
				<div class="col" style="max-width: 100px;">Precio total</div>
				<div class="col" style="max-width: 42px;margin-right: -6px;" style="border-color: transparent">&nbsp;</div>
			</div>
		</div>
		<div class="card-body efect-hover" id="productoSeleccion"></div>
	</div>
</section>
<script type="text/javascript">	
	var listProductosComprar = new Map();
	var dataProductos;
	var productoSeleccionado;
	function getProducto(id){
		for (var i = 0; i < dataProductos.length; i++) {
			if(dataProductos[i].id == id){
				return dataProductos[i];
			}
		}
	}

	function remove(id){
		if(listProductosComprar.delete(id)){
			$("#productoSeleccion .row[data-producto-id='"+id+"']").fadeOut('slow',() => {
				$("#productoSeleccion .row[data-producto-id='"+id+"']").remove();
			});
			calcularTotalView();
			eventActionsFactura();
		}
	}
	
	function calcularTotal(){
		var totalMmoney = 0.0;
		listProductosComprar.forEach((val) => {
			totalMmoney += val.precio*val.cantidad;
		});
		return totalMmoney;
	}

	function calcularTotalView(){
		//var totalMmoney = calcularTotal();
		$(".card-compra-info .total-money").html("$" + calcularTotal().toLocaleString('en-EN', {minimumFractionDigits: 2, maximumFractionDigits:2}))
	}

	function eventActionsFactura(){
		if($("#rowActionsFactura").css("display")=="none" && listProductosComprar.size>0){
			$("#rowActionsFactura").fadeIn("slow");
		}else if(listProductosComprar.size==0){
			$("#rowActionsFactura").fadeOut("slow");
		}
	}

	function eventChangeCantidad(id){
		var producto = listProductosComprar.get(id);
		setTimeout(() => {
			var inputCant = $("#productoSeleccion > .row[data-producto-id='"+producto.id+"'] .txt_cant_pro");
			producto.cantidad = parseInt(inputCant.val().length==0 ? 0 : inputCant.val());
			$("#productoSeleccion > .row[data-producto-id='"+producto.id+"'] .labelPrecioTotal").html("$"+(producto.precio*producto.cantidad).toLocaleString('en-EN', {minimumFractionDigits: 2, maximumFractionDigits:2}));
			
			calcularTotalView();
		}, 200);
	}

	function selecionarProducto(id){
		if(typeof listProductosComprar.get(id)=='undefined'){
			productoSeleccionado = getProducto(id);

			productoSeleccionado['cantidad'] = 1;
			listProductosComprar.set( productoSeleccionado.id, productoSeleccionado);
			
			$("#productoSeleccion").prepend(`
				<div class="row" data-producto-id="`+productoSeleccionado.id+`" style="display:none;">
					<div class="col" style="max-width: 80px;">`+productoSeleccionado.id+`</div>
					<div class="col" style="max-width: 100%;">`+productoSeleccionado.nombre+`</div>
					<div class="col hidden-movil" style="max-width: 90px;">`+productoSeleccionado.marca+`</div>
					<div class="col hidden-movil" style="max-width: 90px;">`+productoSeleccionado.modelo+`</div>
					<div class="col hidden-movil" style="max-width: 100px;">`+productoSeleccionado.categoria.nombre+`</div>
					<div class="col hidden-movil" style="max-width: 100px;">`+productoSeleccionado.proveedor.nombre+`</div>
					<div class="col hidden-movil" style="max-width: 100px;">`+productoSeleccionado.cantidad_existencia.toLocaleString()+`</div>
					<div class="col" style="max-width: 100px;"><div class="form-group"><input type="text" class="form-control txt_cant_pro" id="txt_cant_pro__`+productoSeleccionado.id+`" data-mask-as-number-min="1" data-mask-as-number-max="`+productoSeleccionado.cantidad_existencia+`" value="1" placeholder="Cantidad"></div></div>
					<div class="col" style="max-width: 100px;">$`+productoSeleccionado.precio.toLocaleString('en-EN', {minimumFractionDigits: 2, maximumFractionDigits:2})+`</div>
					<div class="col labelPrecioTotal" style="max-width: 100px;" id="labelPrecioTotal">$`+productoSeleccionado.precio.toLocaleString('en-EN', {minimumFractionDigits: 2, maximumFractionDigits:2})+`</div>
					<div class="col col__buttons" style="max-width: 42px; margin: 0px -6px 0px auto;">
						<div class="btn-group">
							<button type="button" class="btn btn__option btn-primary color-btn-card btn-sm" onclick="remove('`+productoSeleccionado.id+`')">
								<span class="material-icons">delete</span>
							</button>
						</div>
					</div>
				</div>
			`);
			setTimeout(() => {
				$("#productoSeleccion > .row[data-producto-id='"+productoSeleccionado.id+"']").fadeIn('slow');
				$("#productoSeleccion > .row[data-producto-id='"+productoSeleccionado.id+"'] .txt_cant_pro").maskAsNumber();
				$("#productoSeleccion > .row[data-producto-id='"+productoSeleccionado.id+"'] .txt_cant_pro").keydown(() => {
					eventChangeCantidad(id);
				});
				calcularTotalView();
				eventActionsFactura();
			}, 10);
		}else{
			$("#productoSeleccion > .row[data-producto-id='"+id+"']").addClass("efect-isselected");
			setTimeout(() => {
				$("#productoSeleccion > .row[data-producto-id='"+id+"']").removeClass("efect-isselected");
			}, 6000);
		}

	}

	function searchAddedProductos(resp){
		var dataResp = JSON.parse(resp);
		dataProductos = dataResp;
		if(typeof dataResp.ERROR=='undefined'){
			$("#listViewProductoSeleccion").html("");
			dataResp.forEach((e) => {
				e.precio = parseFloat(e.precio);
				e.cantidad_existencia = parseInt(e.cantidad_existencia);
				$("#listViewProductoSeleccion").append(`
					<div class="row" data-producto-id="`+e.id+`">
						<div class="col" style="max-width: 80px;">`+e.id+`</div>
						<div class="col" style="max-width: 100%;">`+e.nombre+`</div>
						<div class="col hidden-movil" style="max-width: 100px;">`+e.marca+`</div>
						<div class="col hidden-movil" style="max-width: 100px;">`+e.modelo+`</div>
						<div class="col" style="max-width: 100px;">`+e.cantidad_existencia.toLocaleString()+`</div>
						<div class="col" style="max-width: 150px;">$`+e.precio.toLocaleString('en-EN', {minimumFractionDigits: 2, maximumFractionDigits:2})+`</div>
					</div>
				`);
			});
			$(".titleListProductos").css('display',dataResp.length==0 ? 'none' : '');
			$("#listViewProductoSeleccion .row").click(function(){selecionarProducto($(this).attr("data-producto-id"))});
		}
	}

	function searchProductoId(id){
		Util.post('productos/get',
			{
				'id':id
			},searchAddedProductos);
	}

	function searchProducto(){
		Util.post('productos/get',
			{
				'nombre':$("#txt_nombre_pro").val().trim(),
				'categoria':$("#select__categoria").val(),
				'proveedor':$("#select__proveedor").val()
			},searchAddedProductos);
	}
	$(document).ready(() => {
		$("#txt_cod_pro").keydown(() => {
			setTimeout(() => {
				searchProductoId($("#txt_cod_pro").val());
			}, 10);
		});
		$("#txt_nombre_pro").keydown((e) => {
			setTimeout(()=> {
				searchProducto();
			}, 10);
		});
		$("#select__categoria,#select__proveedor").change(() => {
			setTimeout(() => {
				searchProducto();
			}, 10);
		});
		$("#txt_nombre_pro").keydown();
	});
	$("#btn__finalizar_compra").click(() => {
		var dataCompra = new Array();

		listProductosComprar.forEach((pro) =>{
			dataCompra.push({
				'id' : parseInt(pro.id),
				'cantidad': parseInt(pro.cantidad)
			})
		});

		Util.post("facturar/new/save",
			{
				"dataFactura": JSON.stringify(
					{
						'lista_compra'		: dataCompra,
						'nombre_cliente'	: $("#txt_nombre_cliente").val().trim(),
						'subtotal'				: calcularTotal()
					}
				)
			},
			(resp) => {
				//console.log(resp);
			}
		);

	});
</script>