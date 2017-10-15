<?php
	// Include database class
    $path =  $_SERVER['DOCUMENT_ROOT']."/depotile/config/class_database.php";
    include($path);
    $path =  $_SERVER['DOCUMENT_ROOT']."/depotile/config/serverconfig.php";
    include($path);

    if($_SERVER['REQUEST_METHOD'] == "POST") {
    	$username = $_POST['emailadmin'];
    	$password = hash("md5", $_POST['passwordadmin']);
    	$result = $db->database_prepare(
    		"SELECT * FROM ms_user
    		WHERE email LIKE ?
    		AND password LIKE ?
    		AND user_type LIKE '%admin%'"
    	)->execute($username,$password);
    	$num_row = $db->database_num_rows($result);
		
		if($num_row == 0) {
			$messageError = "Username atau password yang anda gunakan salah atau anda tidak tidak memiliki akses untuk masuk ke menu admin";
			$path = "login.php";
			echo '<script type="text/javascript">window.location.href="'.$path.'?error='.$messageError.'"</script>';
			exit;
		}else {
			$userRow = $db->database_fetch_array($result);
			$_SESSION['userIdAdmin'] = $userRow['id'];
			$_SESSION['emailAdmin'] = $username;
			$_SESSION['userNameAdmin'] = $userRow['name'];
			echo '<script type="text/javascript">window.location.href="/depotile/admin"</script>';
			exit;
		}
    }
?>