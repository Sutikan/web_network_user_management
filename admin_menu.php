<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="nav flex-column my-2" style="min-height: 100vh;">
		<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-light mt-3" style="margin-bottom: 0;"><h3>CTC <span class="text-warning">NETWORK</span></h3></a>
		<hr width="100%" class="border-secondary">
		<a class="disabled nav-link text-warning font-weight-bold">Manage</a>
		<a href="<?php echo "admin_index.php?id=$id" ?>" class="nav-link text-light ml-3">Dashboard</a>
		<a href="<?php echo "admin_profile.php?id=$id" ?>" class="nav-link text-light ml-3">Profile</a>
		<a class="disabled nav-link text-warning font-weight-bold">Generate</a>
		<a href="<?php echo "admin_group.php?id=$id" ?>" class="nav-link text-light ml-3">Generate Group</a>
		<a href="<?php echo "admin_user.php?id=$id" ?>" class="nav-link text-light ml-3">Generate User</a>
		<a class="disabled nav-link text-warning font-weight-bold">Report</a>
		<a href="<?php echo "admin_nre.php?id=$id" ?>" class="nav-link text-light ml-3">Network Report</a>
		<a href="<?php echo "admin_ure.php?id=$id" ?>" class="nav-link text-light ml-3">Users Report</a>
		<hr width="100%" class="border-secondary">
		<button class="btn btn-warning btn-block font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
	</div>

</body>
</html>