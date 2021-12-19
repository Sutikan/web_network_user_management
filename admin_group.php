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

					<div class="row">
						<div class="col">
							<div class="card border-0 mt-3">
								<div class="card-body">
									<div class="row">
										<div class="col border-right">
											<div class="container my-2">
												<h4 class="font-weight-bold text-secondary">Generate Group</h4>
												<hr>

												<form method="post">
													<div class="form-group my-3">
														<span class="font-weight-bold text-secondary">Group Name</span>
														<input type="text" name="gr_name" class="form-control rounded-0" placeholder="Group Name" required>
													</div>
													<div class="form-group my-3">
														<span class="font-weight-bold text-secondary">Simultaneous Use</span>
														<input type="text" name="gr_use" class="form-control rounded-0" placeholder="Simultaneous Use" required>
													</div>
													<div class="form-group my-3">
														<span class="font-weight-bold text-secondary">Idle Timeout</span>
														<input type="text" name="gr_idle" class="form-control rounded-0" placeholder="Idle Timeout" required>
													</div>
													<div class="form-group my-3">
														<span class="font-weight-bold text-secondary">Session Timeout</span>
														<input type="text" name="gr_session" class="form-control rounded-0" placeholder="Session Timeout" required>
													</div>
													<div class="form-group my-3">
														<span class="font-weight-bold text-secondary">Download</span>
														<input type="text" name="gr_down" class="form-control rounded-0" placeholder="Download" required>
													</div>
													<div class="form-group my-3">
														<span class="font-weight-bold text-secondary">Upload</span>
														<input type="text" name="gr_up" class="form-control rounded-0" placeholder="Upload" required>
													</div>
													<hr>
													<button class="btn btn-warning font-weight-bold btn-block" type="submit" name="gen_group">Generate Group</button>
												</form>
											</div>
										</div>

										<div class="col">
											<?php
												if (isset($_POST['gen_group'])) {
													$gr_name = $_POST['gr_name'];
													$gr_use = $_POST['gr_use'];
													$gr_idle = $_POST['gr_idle'];
													$gr_session = $_POST['gr_session'];
													$gr_down = $_POST['gr_down'];
													$gr_up = $_POST['gr_up'];

													$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$gr_name', 'Auth-Type', ':=', 'Accept')");
													$genGroup = mysqli_query($con, "INSERT INTO radgroupcheck (groupname, attribute, op, value) VALUES ('$gr_name', 'Simultaneous-Use', ':=', '$gr_use')");
													$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gr_name', 'Acct-Interim-Interval', ':=', '60')");
													$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gr_name', 'Idle-Timeout', ':=', '$gr_idle')");
													$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gr_name', 'Session-Timeout', ':=', '$gr_session')");
													$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gr_name', 'WISPr-Bandwidth-Max-Down', ':=', '$gr_down')");
													$genGroup = mysqli_query($con, "INSERT INTO radgroupreply (groupname, attribute, op, value) VALUES ('$gr_name', 'WISPr-Bandwidth-Max-Up', ':=', '$gr_up')");
											?>
											<div class="container my-2">
												<h4 class="font-weight-bold text-secondary">Group</h4>
												<hr>

												<div class="table-responsive-lg">
													<table class="table text-center table-bordered">
														 <thead style="background-color: #eaeaea;">
														 	<th>Group</th>
														 	<th>Simultaneous Use</th>
														 	<th>Idle Timeout</th>
														 	<th>Session Timeout</th>
														 	<th>Download</th>
														 	<th>Upload</th>
														</thead>
														<tbody>
														 	<th><?php echo $gr_name; ?></th>
														 	<th><?php echo $gr_use; ?></th>
														 	<th><?php echo $gr_idle; ?></th>
														 	<th><?php echo $gr_session; ?></th>
														 	<th><?php echo $gr_down; ?></th>
														 	<th><?php echo $gr_up; ?></th>
														</tbody>
													</table>
													<div class="alert alert-info font-weight-bold text-center">Generate group successful</div>
													<form method="post">
														<button class="btn btn-secondary btn-block font-weight-bold" type="submit" name="con_genGroup">Confirm</button>
													</form>
													<?php
														if (isset($_POST['con_genGroup'])) {
														 	echo "<script>window.location.href='admin_group.php?id=$id'</script>";
														}
													?>
												</div>
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
	</div>
	
</body>
</html>
<?php } ?>