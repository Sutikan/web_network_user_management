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
									<div class="container-fluid">
										<h3 class="font-weight-bold text-warning">Welcome <small class="text-dark font-weight-bold"><?php echo $username; ?></small></h3>
										<small class="text-secondary">Have many user wait for approve</small>
									</div>
								</div>
								<div class="col">
									<div class="container">
										<div class="nav nav-pills nav-justified mt-3 font-weight-bold">
											<a href="#appro" class="nav-link active font-weight-bold" data-toggle="pill">Approval</a>
											<a href="#suspend" class="nav-link font-weight-bold" data-toggle="pill">Suspened</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card border-0 mt-3">
						<div class="card-body">

							<div class="tab-content">
								<div class="tab-pane fade show active" id="appro">
									<h3 class="text-secondary font-weight-bold">Approve User</h3>
									<hr>
									<div class="table-responsive-lg text-center">
										<table class="table table-bordered border-secondary">
											<thead style="background-color: #eaeaea;">
												<th>ID</th>
												<th>Username</th>
												<th>Name</th>
												<th>Lastname</th>
												<th>Manage</th>
											</thead>
											<tbody>
												<?php 
													$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND radcheck.username != '$username' AND attribute != 'Cleartext-Password'"); 
													while ($show = mysqli_fetch_array($showdata)) { ?>
													<tr class="bg-white">
														<td><?php echo $show['id']; ?></td>
														<td><?php echo $show['username']; ?></td>
														<td><?php echo $show['m_name']; ?></td>
														<td><?php echo $show['m_lastname']; ?></td>
														<td><button class="btn btn-block btn-sm btn-info font-weight-bold" type="button" data-toggle="modal" data-target="#approU<?php echo $show['id'] ?>">Approve</button></td>
													</tr>
													<div class="modal fade" id="approU<?php echo $show['id'] ?>">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<form method="post">
																	<div class="modal-header bg-info text-light">
																		<h4 class="modal-title">Approve User</h4>
																		<button class="close" type="button" data-dismiss="modal">&times;</button>
																	</div>
																	<div class="modal-body text-left">
																		<div class="form-group">
																			<span class="font-weight-bold text-secondary">Name</span>
																			<div class="form-row my-3">
																				<div class="col">
																					<input type="text" class="form-control rounded-0" placeholder="Name" required value="<?php echo $show['m_name'] ?>" disabled>
																				</div>
																				<div class="col">
																					<input type="text" class="form-control rounded-0" placeholder="Lastname" required value="<?php echo $show['m_lastname'] ?>" disabled>
																				</div>
																			</div>
																		</div>
																		<div class="form-group">
																			<span class="font-weight-bold text-secondary">Username</span>
																			<input type="text" class="form-control rounded-0" placeholder="Username" required value="<?php echo $show['username'] ?>" disabled>
																		</div>
																		<div class="form-group">
																			<span class="font-weight-bold text-secondary">Group</span>
																			<select class="form-control" name="app_group">
																				<option value="Default">Defalut</option>
																				<?php
																				$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																				while ($loop = mysqli_fetch_assoc($loopgroup)) { ?>
																					<option value="<?php echo $loop['groupname'] ?>"><?php echo $loop['groupname'] ?></option>
																				<?php	}	?>
																			</select>
																		</div>
																		<span>Do you want to <span class="font-weight-bold text-info">Approve</span>?</span>
																	</div>
																	<div class="modal-footer">
																		<input type="hidden" name="app_username" value="<?php echo $show['username'] ?>">
																		<button class="btn btn-info font-weight-bold" type="submit" name="appro_U">Approve</button>
																		<button class="btn btn-light font-weight-bold" type="button" data-dismiss="modal">Cancel</button>
																	</div>
																</form>
																<?php
																	if (isset($_POST['appro_U'])) {
																		$app_group = $_POST['app_group'];
																		$app_username = $_POST['app_username'];

																		$approUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Cleartext-Password' WHERE username = '$app_username'");
																		if ($app_group === 'Default') {
																			echo "<script>alert('Approve user successful')</script>";
																			echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																			exit();
																		} else {
																			$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$app_username'");
																			$checkU = mysqli_num_rows($checkUG);
																			if ($checkU !== 1) {
																				$userGroup = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$app_username', '$app_group', '1')");
																				echo "<script>alert('Approve user successful')</script>";
																				echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																			}
																		}
																	}
																?>
															</div>
														</div>
													</div>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="suspend">
									<h3 class="text-secondary font-weight-bold">Suspend User</h3>
									<hr>
									<div class="table-responsive-lg text-center">
										<table class="table table-bordered border-secondary">
											<thead style="background-color: #eaeaea;">
												<th>ID</th>
												<th>Username</th>
												<th>Name</th>
												<th>Lastname</th>
												<th>Manage</th>
											</thead>
											<tbody>
												<?php 
													$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND radcheck.username != '$username' AND attribute = 'Cleartext-Password'"); 
													while ($show = mysqli_fetch_array($showdata)) { 
														$sUsername = $show['username']; ?>
													<tr class="bg-white">
														<td><?php echo $show['id']; ?></td>
														<td><?php echo $show['username']; ?></td>
														<td><?php echo $show['m_name']; ?></td>
														<td><?php echo $show['m_lastname']; ?></td>
														<td><button class="btn btn-block btn-sm btn-secondary font-weight-bold" type="button" data-toggle="modal" data-target="#approU<?php echo $show['id'] ?>">Suspend</button></td>
													</tr>
													<div class="modal fade" id="approU<?php echo $show['id'] ?>">
														<div class="modal-dialog modal-dialog-centered">
															<div class="modal-content">
																<form method="post">
																	<div class="modal-header bg-secondary text-light">
																		<h4 class="modal-title">Suspend User</h4>
																		<button class="close" type="button" data-dismiss="modal">&times;</button>
																	</div>
																	<div class="modal-body text-left">
																		<div class="form-group">
																			<span class="font-weight-bold text-secondary">Name</span>
																			<div class="form-row my-3">
																				<div class="col">
																					<input type="text" class="form-control rounded-0" placeholder="Name" required value="<?php echo $show['m_name'] ?>" disabled>
																				</div>
																				<div class="col">
																					<input type="text" class="form-control rounded-0" placeholder="Lastname" required value="<?php echo $show['m_lastname'] ?>" disabled>
																				</div>
																			</div>
																		</div>
																		<div class="form-group">
																			<span class="font-weight-bold text-secondary">Username</span>
																			<input type="text" class="form-control rounded-0" placeholder="Username" required value="<?php echo $show['username'] ?>" disabled>
																		</div>
																		<div class="form-group">
																			<span class="font-weight-bold text-secondary">Group</span>
																			<select class="form-control" disabled>
																				<?php 
																				$sus_group = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$sUsername'");
																				$s_G = mysqli_fetch_assoc($sus_group);
																				if ($s_G) {
																				 	echo "<option>".$s_G['groupname']."</option>";
																				 } else {
																				 	echo "<option>Default</option>";
																				 } ?>
																			</select>
																		</div>
																		<span>Do you want to <span class="font-weight-bold text-secondary">Suspend</span>?</span>
																	</div>
																	<div class="modal-footer">
																		<input type="hidden" name="sus_username" value="<?php echo $show['username'] ?>">
																		<button class="btn btn-secondary font-weight-bold" type="submit" name="sus_U">Suspend</button>
																		<button class="btn btn-light font-weight-bold" type="button" data-dismiss="modal">Cancel</button>
																	</div>
																</form>
																<?php
																	if (isset($_POST['sus_U'])) {
																		$sus_username = $_POST['sus_username'];

																		$approUser = mysqli_query($con, "UPDATE radcheck SET attribute = 'Password' WHERE username = '$sus_username'");
																		echo "<script>alert('Suspend user successful')</script>";
																		echo "<script>window.location.href='admin_index.php?id=$id'</script>";
																	}
																?>
															</div>
														</div>
													</div>
												<?php } ?>
											</tbody>
										</table>
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