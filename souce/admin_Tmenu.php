<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="navbar navbar-dark bg-dark navbar-expand-lg d-block">
		<div class="container-fluid">
			<a href="<?php echo "admin_index.php?id=$id" ?>" class="navbar-brand d-md-none">CTC <span class="text-warning">NETWORK</span></a>

			<button class="navbar-toggler d-block d-md-none" type="button" data-toggle="collapse" data-target="#menu"><span class="navbar-toggler-icon"></span></button>
			<nav class="collapse navbar-collapse" id="menu">
				<div class="d-lg-none">
					<a class="nav-link disabled text-warning font-weight-bold">Manage</a>
					<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-light ml-3">Dashboard</a>
					<a href="<?php echo "admin_profile.php?id=$id" ?>" class="nav-link text-light ml-3">Profile</a>
					<a class="nav-link disabled text-warning font-weight-bold">Generate</a>
					<a href="<?php echo "admin_group.php?id=$id" ?>" class="nav-link text-light ml-3">Generate Group</a>
					<a href="<?php echo "admin_user.php?id=$id" ?>" class="nav-link text-light ml-3">Generate User</a>
					<a class="nav-link disabled text-warning font-weight-bold">Report</a>
					<a href="<?php echo "admin_nre.php?id=$id" ?>" class="nav-link text-light ml-3">Network</a>
					<a href="<?php echo "admin_ure.php?id=$id" ?>" class="nav-link text-light ml-3">Users</a>
					<hr width="100%" class="border-secondary">
					<button class="btn btn-warning btn-block font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
				</div>
			</nav>
			<div class="ml-auto d-none d-md-block">
				<button class="btn btn-warning font-weight-bold btn-sm" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
			</div>
		</div>
	</div>

</body>
</html>