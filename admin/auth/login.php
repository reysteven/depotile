<?php
    $path = $_SERVER['DOCUMENT_ROOT']."/depotile/pages/header.php";
    include_once($path);

    if(isset($_SESSION['userIdAdmin']) && $_SESSION['userIdAdmin'] != "") {
        $path = "/depotile/admin";
        echo '<script type="text/javascript">window.location.href="'.$path.'"</script>';
    }
?>
<style type="text/css">
	body {
		padding: 0 !important;
	}
</style>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" id="admin-navbar">
    <div class="navbar-header">
        <a class="navbar-brand" href="/depotile/admin/">Admin Menu</a>
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <a href="/depotile" target="_blank">Kunjungi Website</a>
        </li>
        <li>
            <a href="/depotile/admin/auth/doLogout.php">Log Out</a>
        </li>
    </ul>
</nav>
<div class="container-fluid" style="margin-top:70px">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<?php
						if(isset($_GET['error'])) {
					?>
					<div class="alert alert-danger">
						<strong>Whoops!</strong> Ada masalah dengan input yang anda masukkan.<br><br>
						<strong><?php echo $_GET['error'] ?></strong>
					</div>
					<?php
						}
					?>

					<form class="form-horizontal" role="form" method="POST" action="doLogin.php">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="emailadmin" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="passwordadmin">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Login</button>

								<a class="btn btn-link" href="#">Forgot Your Password?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>