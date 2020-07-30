<?php
	$this->getSessionManager()->destroyAll();
?>
<script type="text/javascript">
	window.location = "<?php echo _DIR_."login";?>";
</script>
<meta http-equiv="refresh" content="0; URL=<?php echo _DIR_."login";?>">