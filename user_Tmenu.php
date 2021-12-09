<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="navbar navbar-expand-lg navbar-dark bg-dark d-block">
		<div class="container-fluid">
			<a href="<?php echo "user_index.php?id=$id" ?>" class="navbar-brand font-weight-bold d-md-none">CTC <span class="text-warning">NETWORK</span></a>
			<button class="navbar-toggler d-block d-md-none" data-toggle="collapse" data-target="#menu"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="menu">
				<div class="d-lg-none">
					<a class="disabled nav-link text-warning font-weight-bold">Manage</a>
					<a href="<?php echo "user_index.php?id=$id" ?>" class="nav-link text-light ml-3">Dashboard</a>
					<a href="<?php echo "user_profile.php?id=$id" ?>" class="nav-link text-light ml-3">Profile</a>
					<hr width="100%" class="border-secondary">
					<button class="btn btn-warning btn-block font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
				</div>
			</div>
			<div class="ml-auto d-none d-md-block">
				<button class="btn btn-warning btn-sm font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
			</div>
		</div>
	</div>

	<div class="modal fade" id="logout">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form method="post">
					<div class="modal-header bg-danger text-light">
						<h4 class="modal-title">Log Out</h4>
						<button class="close" type="button" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<span>Do you want to <span class="font-weight-bold text-danger">Log Out</span>?</span>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger font-weight-bold" type="submit" name="log_out">Log Out</button>
						<button class="btn btn-light font-weight-bold" type="button" data-dismiss="modal">Cancel</button>
					</div>
				</form>
				<?php
					if (isset($_POST['log_out'])) {
						session_destroy();
						echo "<script>window.location.href='index.php'</script>";
					}
				?>
			</div>
		</div>
	</div>

</body>
</html>