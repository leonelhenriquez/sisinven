<?php
	$queryFactura = $this->getDatabase()->Query(sprintf(
		"SELECT f.id_factura,f.fecha,f.hora,f.nombre_cliente,
						f.subtotal,f.usuario,f.empresa, 
						u.username, u.nombre, u.apellido 
		FROM factura AS f 
		JOIN users AS u ON u.id_user=f.usuario 
		WHERE f.empresa = '%d' ORDER BY f.fecha DESC,f.hora DESC LIMIT 5",
		$this->UserData->getEmpresa()
	));

	$listFacturas = array();

	while($factura = $this->getDatabase()->FetchArray($queryFactura)){
		array_push(
			$listFacturas, 
			(new app\Factura())
			->setId($factura['id_factura'])
			->setFecha($factura['fecha'])
			->setHora($factura['hora'])
			->setNombreCliente($factura['nombre_cliente'])
			->setSubTotal($factura['subtotal'])
			->setUsuario(
				(new app\User())
				->setId($factura['id_factura'])
				->setUsername($factura['username'])
				->setNombre($factura['nombre'])
				->setApellido($factura['apellido'])
			)
		);
	}
/**
SELECT * FROM (
    SELECT * FROM productos WHERE cantidad_existencia <=10
    UNION ALL
    SELECT * FROM productos WHERE cantidad_existencia > 10
) productos GROUP BY productos.id_producto ORDER BY productos.cantidad_existencia ASC
*/
	$queryProductos = $this->getDatabase()->Query(sprintf("
			SELECT p.id_producto, p.nombre, p.marca, p.modelo, 
					p.cantidad_existencia, p.descripcion, p.precio, 
					p.categoria, c.nombre AS nombrecat, 
					p.proveedor, prov.nombre AS nombreprov 
			FROM productos AS p 
			JOIN categorias AS c ON c.id_categoria=p.categoria 
			JOIN proveedor AS prov ON prov.id_proveedor=p.proveedor 
			WHERE p.removed=0 AND p.empresa = '%d' AND cantidad_existencia <=15 ORDER BY p.cantidad_existencia ASC",
		$this->UserData->getEmpresa()
	));

	$listProductos = array();

	while ($pro = $this->getDatabase()->FetchArray($queryProductos)) {
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

?>
<section id="view_home">

	<div class="row alert__grid">
		<?php foreach ($listProductos as $pro) { ?>

		<div class="card alert-danger col-6 <?php echo $pro->getCantidadExistencia()<=10 ? "bg_alert" : "bg_warning" ; ?>" >
			<div class="card-body">
					<div class="row">
						<div class="col" style="max-width: 200px">Codigo Producto:</div>
						<div class="col"><?php echo $pro->getId(); ?></div>
					</div>
					<div class="row">
						<div class="col" style="max-width: 200px">Nombre producto:</div>
						<div class="col"><?php echo $pro->getNombre(); ?></div>
					</div>
					<div class="row">
						<div class="col" style="max-width: 200px">Cantidad existencia:</div>
						<div class="col"><?php echo $pro->getCantidadExistencia(); ?></div>
					</div>
					<div class="txt_error">
						<?php echo $pro->getCantidadExistencia()<=10 ? "El producto contiene pocas existencias para vender" : "El producto esta pronto a terminarse"; ?>
					</div>
			</div>
		</div>
		<?php } ?>
	</div>

</section>

<section id="view_facturar_new">


	<div class="card addedbox custom-color custom-color-dark" id="productoSeleccionBox" style=" background-color: #4CAF50;">
		<div class="card-body">
			<div class="row title__productos" style="background-color: transparent;">
				<div class="col" style="max-width: 100%;">Facturas recientes</div>
			</div>
			<div class="row title__productos" style="background-color: rgba(0, 0, 0, 0.05);">
				<div class="col" style="max-width: 100px;">#</div>
				<div class="col" style="max-width: 100%;">Nombre cliente</div>
				<div class="col" style="max-width: 200px;">Total</div>
				<div class="col" style="max-width: 200px;">Fecha</div>
				<div class="col" style="max-width: 200px;">Hora</div>
				<div class="col" style="max-width: 200px;">Vendedor</div>
			</div>
<?php

	foreach ($listFacturas as $fac) {
?>
			<div class="row">
				<div class="col" style="max-width: 100px;"><?php echo $fac->getId(); ?></div>
				<div class="col" style="max-width: 100%;"><?php echo $fac->getNombreCliente()!="" ? $fac->getNombreCliente() : "No establecido"; ?></div>
				<div class="col" style="max-width: 200px;"><?php echo '$'.Wave\Util::moneyFormat($fac->getSubTotal()); ?></div>
				<div class="col" style="max-width: 200px;"><?php echo $fac->getFecha('d/m/Y'); ?></div>
				<div class="col" style="max-width: 200px;"><?php echo $fac->getHora('h:i a'); ?></div>
				<div class="col" style="max-width: 200px;"><?php echo $fac->getUsuario()->getNombre()." ".$fac->getUsuario()->getApellido(); ?></div>
			</div>
<?php 
	}	
?>

		</div>
	</div>
</section>