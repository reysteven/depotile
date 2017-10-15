<?php
	session_start();
	session_unset();
	// die(json_encode($_SESSION));
	$path = "/depotile/admin";
	echo '<script type="text/javascript">window.location.href="'.$path.'"</script>';
	exit;
?>