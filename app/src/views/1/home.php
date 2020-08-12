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
?>


	<div class="card addedbox custom-color custom-color-dark" id="productoSeleccionBox" style=" background-color: #607D8B;">
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