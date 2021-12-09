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

							<h3 class="text-secondary font-weight-bold">Users Report</h3>
							<hr>
							<div class="table-responsive-lg text-center">
								<table class="table table-bordered border-secondary">
									<thead style="background-color: #eaeaea;">
										<th>ID</th>
										<th>Username</th>
										<th>Name</th>
										<th>Lastname</th>
										<th>Group</th>
										<th>Manage</th>
									</thead>
									<tbody>
										<?php 
											$showdata = mysqli_query($con, "SELECT * FROM radcheck, member WHERE radcheck.username = member.username AND radcheck.username != '$username' AND attribute = 'Cleartext-Password'"); 
											while ($show = mysqli_fetch_array($showdata)) { 
												$show_username = $show['username'];?>
												<tr class="bg-white">
													<td><?php echo $show['id']; ?></td>
													<td><?php echo $show['username']; ?></td>
													<td><?php echo $show['m_name']; ?></td>
													<td><?php echo $show['m_lastname']; ?></td>
													<td><?php $group = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$show_username'");
															  $checkG2 = mysqli_fetch_assoc($group);
															  $chckG = mysqli_num_rows($group);
													if ($chckG === 1) {
													 	echo $checkG2['groupname'];
													 } else {
													 	echo "-";
													 } ?></td>
													<td>
														<div class="btn-group btn-group-sm">
															<button class="btn btn-info font-weight-bold px-3" type="button" data-toggle="modal" data-target="#upU<?php echo $show['id'] ?>">Edit</button>
															<button class="btn btn-secondary font-weight-bold" type="button" data-toggle="modal" data-target="#delU<?php echo $show['id'] ?>">Delete</button>
														</div>
													</td>
												</tr>
												<div class="modal fade" id="upU<?php echo $show['id'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="modal-header bg-info text-light">
																	<h4 class="modal-title">Update User</h4>
																	<button class="close" type="button" data-dismiss="modal">&times;</button>
																</div>
																<div class="modal-body text-left">
																	<div class="form-group">
																		<span class="font-weight-bold text-secondary">Username</span>
																		<input type="text" class="form-control rounded-0" placeholder="Username" required value="<?php echo $show['username'] ?>" disabled>
																	</div>
																	<div class="form-group">
																		<span class="font-weight-bold text-secondary">Name</span>
																		<div class="form-row my-3">
																			<div class="col">
																				<input type="text" class="form-control rounded-0" placeholder="Name" name="up_name" required value="<?php echo $show['m_name'] ?>">
																			</div>
																			<div class="col">
																				<input type="text" class="form-control rounded-0" placeholder="Lastname" name="up_lastname" required value="<?php echo $show['m_lastname'] ?>">
																			</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<span class="font-weight-bold text-secondary">Group</span>
																		<select class="form-control" name="up_group">
																			<?php if ($chckG === 1) { ?>
																				<option value="<?php echo $checkG2['groupname'] ?>"><?php echo $checkG2['groupname'] ?></option>
																			<?php } ?>
																			<option value="Default">Defalut</option>
																			<?php
																				$loopgroup = mysqli_query($con, "SELECT DISTINCT groupname FROM radgroupcheck");
																				while ($loop = mysqli_fetch_assoc($loopgroup)) { ?>
																					<option value="<?php echo $loop['groupname'] ?>"><?php echo $loop['groupname'] ?></option>
																			<?php	}	?>
																		</select>
																	</div>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="up_username" value="<?php echo $show['username'] ?>">
																	<button class="btn btn-info font-weight-bold" type="submit" name="up_U">Update</button>
																	<button class="btn btn-light font-weight-bold" type="button" data-dismiss="modal">Cancel</button>
																</div>
															</form>
															<?php
																if (isset($_POST['up_U'])) {
																	$up_name = $_POST['up_name'];
																	$up_lastname = $_POST['up_lastname'];
																	$up_group = $_POST['up_group'];
																	$up_username = $_POST['up_username'];

																	$upUser = mysqli_query($con, "UPDATE member SET m_name = '$up_name', m_lastname = '$up_lastname', m_update = NOW(), m_who = '$username' WHERE username = '$up_username'");
																	if ($up_group === 'Default') {
																		echo "<script>alert('Update user successful')</script>";
																		echo "<script>window.location.href='admin_ure.php?id=$id'</script>";
																		exit();
																	} else {
																		$checkUG = mysqli_query($con, "SELECT * FROM radusergroup WHERE username = '$up_username'");
																		$checkU = mysqli_num_rows($checkUG);
																		if ($checkU !== 1) {
																			$userGroup = mysqli_query($con, "INSERT INTO radusergroup (username, groupname, priority) VALUES ('$up_username', '$up_group', '1')");
																			echo "<script>alert('Update user successful')</script>";
																			echo "<script>window.location.href='admin_ure.php?id=$id'</script>";
																		}
																	}
																}
															?>
														</div>
													</div>
												</div>
												<div class="modal fade" id="delU<?php echo $show['id'] ?>">
													<div class="modal-dialog modal-dialog-centered">
														<div class="modal-content">
															<form method="post">
																<div class="modal-header bg-secondary text-light">
																	<h4 class="modal-title">Delete User</h4>
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
																		<select class="form-control" name="app_group" disabled>
																			<?php if ($chckG === 1) { ?>
																				<option value="<?php echo $checkG2['groupname'] ?>"><?php echo $checkG2['groupname'] ?></option>
																			<?php } ?>
																			<option value="Default">Defalut</option>
																		</select>
																		</div>
																		<span>Do you want to <span class="font-weight-bold text-secondary">Delete</span>?</span>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="del_username" value="<?php echo $show['username'] ?>">
																	<button class="btn btn-secondary font-weight-bold" type="submit" name="del_U">Delete</button>
																	<button class="btn btn-light font-weight-bold" type="button" data-dismiss="modal">Cancel</button>
																</div>
															</form>
															<?php
																if (isset($_POST['del_U'])) {
																	$del_username = $_POST['del_username'];

																	$delUser = mysqli_query($con, "DELETE FROM radcheck WHERE username = '$del_username'");
																	$delUser = mysqli_query($con, "DELETE FROM member WHERE username = '$del_username'");

																	if ($chckG === 1) {
																		$delGroup = mysqli_query($con, "DELETE FROM radusergroup WHERE username = '$del_username'");
																		echo "<script>alert('Delete user successful')</script>";
																		echo "<script>window.location.href='admin_ure.php?id=$id'</script>";
																	} else {
																		echo "<script>alert('Delete user successful')</script>";
																		echo "<script>window.location.href='admin_ure.php?id=$id'</script>";
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
					</div>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>
<?php } ?>
