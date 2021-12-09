<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<div class="nav flex-column my-2" style="min-height: 100vh;">
		<a href="<?php echo "user_index.php?id=$id" ?>" class="nav-link text-light mt-3" style="margin-bottom: 0;"><h3>CTC <span class="text-warning">NETWORK</span></h3></a>
		<hr width="100%" class="border-secondary">
		<a class="disabled nav-link text-warning font-weight-bold">Manage</a>
		<a href="<?php echo "user_index.php?id=$id" ?>" class="nav-link text-light ml-3">Dashboard</a>
		<a href="<?php echo "user_profile.php?id=$id" ?>" class="nav-link text-light ml-3">Profile</a>
		<hr width="100%" class="border-secondary">
		<button class="btn btn-warning btn-block font-weight-bold" type="button" data-toggle="modal" data-target="#logout">Log Out</button>
	</div>

</body>
</html>