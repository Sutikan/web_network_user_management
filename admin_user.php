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
			<div class="col-auto col-sm-auto col-md-auto d-none bg-dark d-sm-block"><?php include 'admin_menu.php'; ?></div>
			<div class="col col-sm col-md" style="padding: 0;">
				<?php include 'admin_Tmenu.php'; ?>

				<div class="container-fluid">

					<div class="card border-0 mt-3">
						<div class="card-body">

							<div class="row">
								<div class="col border-right">
									<div class="container my-2">
										<h4 class="font-weight-bold text-secondary">Generate Users</h4>
										<small class="text-muted">For generate more 1 user</small>
										<hr>

										<form method="post">
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Number of user</span>
												<input type="text" class="form-control rounded-0" name="gen_num" placeholder="Number of user" required>
											</div>
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Group</span>
												<select name="gen_group" class="form-control rounded-0">
													<option value="Defalut">Defalut</option>
													<?php
														$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
														while ($loop = mysqli_fetch_assoc($loopgroup)) { ?>
															<option value="<?php echo $loop['groupname'] ?>"><?php echo $loop['groupname'] ?></option>
													<?php	}	?>
												</select>
											</div>
											<hr>
											<div class="text-right"><button class="btn btn-secondary font-weight-bold px-4" type="submit" name="gen_users">Generate Users</button></div>
										</form>
										<hr width="20%" class="my-3">
										<h4 class="font-weight-bold text-secondary">Generate User</h4> 
										<small class="text-muted">For generate only 1 user</small>
										<hr>

										<form method="post">
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Username</span>
												<input type="text" class="form-control rounded-0" name="g_username" placeholder="Username" required>
											</div>
											<div class="form-group my-3">
												<div class="form-row my-3">
													<div class="col">
														<span class="font-weight-bold text-secondary">Name</span>
														<input type="text" name="g_name" class="form-control rounded-0" placeholder="Name" required>
													</div>
													<div class="col">
														<span class="font-weight-bold text-secondary">Lastname</span>
														<input type="text" name="g_lastname" class="form-control rounded-0" placeholder="Lastname" required>
													</div>
												</div>
											</div>
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Password</span>
												<input type="password" class="form-control rounded-0" name="g_pass" placeholder="Password" required>
											</div>
											<div class="form-group my-3">
												<span class="font-weight-bold text-secondary">Group</span>
												<select name="g_group" class="form-control rounded-0">
													<option value="Defalut">Defalut</option>
													<?php
														$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
														while ($loop = mysqli_fetch_assoc($loopgroup)) { ?>
															<option value="<?php echo $loop['groupname'] ?>"><?php echo $loop['groupname'] ?></option>
													<?php	}	?>
												</select>
											</div>
											<hr>
											<div class="text-right"><button class="btn btn-warning font-weight-bold px-4" type="submit" name="gen_user">Generate User</button></div>
										</form>
										<?php
											if (isset($_POST['gen_user'])) {
												$g_username = $_POST['g_username'];
												$g_name = $_POST['g_name'];
												$g_lastname = $_POST['g_lastname'];
												$g_pass = $_POST['g_pass'];
												$g_group = $_POST['g_group'];

												$checkname = mysqli_query($con, "SELECT * FROM radcheck WHERE username = '".trim($g_username)."'");
												$check = mysqli_num_rows($checkname);
												if ($check === 1) {
													echo "<script>alert('This username is already exsits!')</script>";
													echo "<script>window.location.href='admin_user.php?id=$id'</script>";
												} else {
													$genUser = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$g_username', 'Cleartext-Password', ':=', '$g_pass')");
													$genUser = mysqli_query($con, "INSERT INTO member (username, m_name, m_lastname) VALUES ('$g_username', '$g_name', '$g_lastname')");

													if ($g_group === 'Defalut') {
														echo "<script>alert('Generate user successful')</script>";
														echo "<script>window.location.href='admin_user.php?id=$id'</script>";
													} else {
														$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '".trim($g_username)."'");
														$checkU = mysqli_num_rows($checkUG);
														if ($checkU !== 1) {
															$Usergroup = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$g_username', '$g_group', '1')");
															echo "<script>alert('Generate user successful')</script>";
															echo "<script>window.location.href='admin_user.php?id=$id'</script>";
														}
													}
												}
											}
										?>
									</div>
								</div>
								<div class="col">
									<div class="container my-2">
										<?php
											if (isset($_POST['gen_users'])) { ?>
											<h4 class="font-weight-bold text-secondary mb-2">Users</h4> 
											<hr>
											<div class="table-responsive-lg">
												<table class="table table-bordered">
													<thead style="background-color: #eaeaea;">
														<th>Username</th>
														<th>Password</th>
														<th>Group</th>
													</thead>
													<tbody>
														<?php
															$gen_num = $_POST['gen_num'];
													 		$gen_group = $_POST['gen_group'];
													 	
															for ($i=0; $i <$gen_num ; $i++) { 
																$char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
																$num = "1234567890";
																$subC = str_shuffle($char);
																$subN = str_shuffle($num);
																$gen_username = substr($gen_group, 0, 3).substr($subC, 0, 3).substr($subN, 0, 2);
																$gen_pass = substr($subN, 0, 6);

																$genUsers = mysqli_query($con, "INSERT INTO radcheck (username, attribute, op, value) VALUES ('$gen_username', 'Cleartext-Password', ':=', '$gen_pass')");
																$genUsers = mysqli_query($con, "INSERT INTO member (username) VALUES ('$gen_username')");
																if ($gen_group !== 'Defalut') {
																	$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '".trim($gen_username)."'");
																	$checkU = mysqli_num_rows($checkUG);
																	if ($checkU !== 1) {
																		$Usergroup = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$gen_username', '$gen_group', '1')");
																	}
																}
														?>
															<tr>
																<td><?php echo $gen_username; ?></td>
																<td><?php echo $gen_pass; ?></td>
																<td><?php echo $gen_group; ?></td>
															</tr>
														<?php }	?>
													</tbody>
												</table>
												<div class="alert alert-info font-weight-bold text-center">Generate users successful</div>
												<form method="post">
													<button class="btn btn-secondary btn-block font-weight-bold" type="submit" name="con_genUsers">Confirm</button>
												</form>
												<?php
													if (isset($_POST['con_genUsers'])) {
														echo "<script>window.location.href='admin_user.php?id=$id'</script>";
														exit();
													}
												?>
											</div>
										<?php } ?>
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