<?php
if($isHttpAjaxRequest){
	echo json_encode(array("ERROR" => 'Error 404'));
}else{
?>
	<div id="view__page404">
		<div class="content">
			<div>
				<h1>Error 404</h1>
				<p>La pagina solicitada no a sido encontrada</p>
			</div>
		</div>
	</div>
<?php 
}
?>	