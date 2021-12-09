<?php
	@session_start();
	include 'connect.php';
	$id = $_SESSION['id'];
	$username = $_SESSION['username'];

	if (!isset($_SESSION['id'])) {
		echo "<script>window.location.href='index.php'</script>";
	} else {
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CTC NETWORK</title>
	<link rel="stylesheet" type="text/css" href="bootstrap-4.6.1-dist/css/bootstrap.css">
	<script type="text/javascript" src="jquery/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="bootstrap-4.6.1-dist/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #eaeaea;">

	<div class="container-fluid h-100">
		<div class="row h-100">
			<div class="col-auto col-sm-auto col-md-auto d-none bg-dark d-sm-block"><?php include 'user_menu.php'; ?></div>
			<div class="col col-sm col-md" style="padding: 0;">
				<?php include 'user_Tmenu.php'; ?>

				<div class="container-fluid">

					<div class="card border-0 mt-3">
						<div class="card-body">

							<?php
								$Profile = mysqli_query($con, "SELECT * FROM member WHERE username = '$username'");
								$showP = mysqli_fetch_assoc($Profile);
							?>

							<div class="row">
								<div class="col border-right">
									<div class="container my-2">
										<h4 class="font-weight-bold text-secondary">Profile Setting</h4>
										<hr>

										<form method="post">
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Username</span>
												<input type="text" class="form-control rounded-0" value="<?php echo $username ?>" disabled>
											</div>
											<div class="form-group my-3">
												<div class="form-row my-3">
													<div class="col">
														<span class="font-weight-bold text-secondary">Name</span>
														<input type="text" name="p_name" class="form-control rounded-0" placeholder="Name" value="<?php echo $showP['m_name'] ?>" required>
													</div>
													<div class="col">
														<span class="font-weight-bold text-secondary">Lastname</span>
														<input type="text" name="p_lastname" class="form-control rounded-0" placeholder="Lastname" value="<?php echo $showP['m_lastname'] ?>" required>
													</div>
												</div>
											</div>
											<hr>
											<div class="text-right"><button class="btn btn-warning font-weight-bold px-4" type="submit" name="up_pro">Update Profile</button></div>
										</form>
										<?php
											if (isset($_POST['up_pro'])) {
												$p_name = $_POST['p_name'];
												$p_lastname = $_POST['p_lastname'];
												$upPro = mysqli_query($con, "UPDATE member SET m_name = '$p_name', m_lastname = '$p_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$username'");
												echo "<script>alert('Update user successful')</script>";
												echo "<script>window.location.href='user_profile.php?id=$id'</script>";
											}
										?>
									</div>
								</div>
								<div class="col">
									<div class="container my-2">
										<h4 class="font-weight-bold text-secondary">Change Password</h4>
										<hr>

										<form method="post">
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Old Password</span>
												<input type="password" class="form-control rounded-0" name="old_pass" placeholder="Old Password" required>
											</div>
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">New Password</span>
												<input type="password" class="form-control rounded-0" name="new_pass" placeholder="New Password" required>
											</div>
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Confirm Password</span>
												<input type="password" class="form-control rounded-0" name="con_pass" placeholder="Confirm Password" required>
											</div>
											<hr>
											<div class="text-right"><button class="btn btn-secondary font-weight-bold px-4" type="submit" name="up_pass">Change Password</button></div>
										</form>
										<?php
											if (isset($_POST['up_pass'])) {
												$old_pass = $_POST['old_pass'];
												$new_pass = $_POST['new_pass'];
												$con_pass = $_POST['con_pass'];

												$checkPass = mysqli_query($con, "SELECT * FROM radcheck WHERE value = '".trim($old_pass)."' AND username = '".trim($username)."'");
												$checkP = mysqli_num_rows($checkPass);
												if ($checkP === 1) {
													if ($new_pass === $con_pass) {
														$upPass = mysqli_query($con, "UPDATE radcheck SET value = '$new_pass' WHERE username = '$username'");
														$upPass = mysqli_query($con, "UPDATE member SET m_update = NOW(), m_who = '$username' WHERE username = '$username'");
														echo "<script>alert('Update password successful')</script>";
														echo "<script>window.location.href='user_profile.php?id=$id'</script>";
													} else {
														echo "<script>alert('Password not match!')</script>";
														echo "<script>window.location.href='user_profile.php?id=$id'</script>";
													}
												} else {
													echo "<script>alert('Your old password is not  correct!')</script>";
													echo "<script>window.location.href='user_profile.php?id=$id'</script>";
												}

											}
										?>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	
</body>
</html>
<?php } ?>