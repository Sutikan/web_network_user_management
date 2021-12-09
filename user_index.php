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
							<div class="row">
								<div class="col border-right">
									<div class="container-fluid">
										<h3 class="font-weight-bold text-warning">Welcome <small class="text-dark font-weight-bold"><?php echo $username; ?></small></h3>
										<small class="text-secondary">We glade to see you again, Hope you enjoy with Internet</small>
									</div>
								</div>
								<div class="col">
									<div class="container">
										<div class="nav nav-pills nav-justified mt-3 font-weight-bold">
											<a href="#network" class="nav-link active" data-toggle="pill">Network</a>
											<a href="#time" class="nav-link" data-toggle="pill">Time</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card border-0 mt-3">
						<div class="card-body">

							<div class="tab-content">
								<div class="tab-pane fade show active" id="network">
									<h3 class="text-secondary font-weight-bold">Network Report</h3>
									<hr>
									<div class="table-responsive-lg text-center">
										<table class="table table-bordered border-secondary">
											<thead style="background-color: #eaeaea;">
												<th>ID</th>
												<th>Username</th>
												<th>IP Address</th>
												<th>Calling Staion</th>
												<th>Session</th>
												<th>Start</th>
												<th>Stop</th>
												<th>Note</th>
											</thead>
											<tbody>
												<?php 
													$showdata = mysqli_query($con, "SELECT * FROM radcheck, radacct WHERE radcheck.username = radacct.username AND radcheck.username = '$username'"); 
													while ($show = mysqli_fetch_array($showdata)) { ?>
													<tr class="bg-white">
														<td><?php echo $show['id']; ?></td>
														<td><?php echo $show['username']; ?></td>
														<td><?php echo $show['framedipaddress']; ?></td>
														<td><?php echo $show['callingstationid']; ?></td>
														<td><?php echo $show['acctsessionid']; ?></td>
														<td><?php echo $show['acctstarttime']; ?></td>
														<td><?php echo $show['acctstoptime']; ?></td>
														<td><?php echo $show['acctterminatecause']; ?></td>													
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane fade" id="time">
									<h3 class="text-secondary font-weight-bold">Time Report</h3>
									<hr>
									<div class="table-responsive-lg text-center">
										<table class="table table-bordered border-secondary">
											<thead style="background-color: #eaeaea;">
												<th>ID</th>
												<th>Username</th>
												<th>Name</th>
												<th>Lastname</th>
												<th>Start</th>
												<th>Stop</th>
												<th>Update</th>
												<th>By</th>
											</thead>
											<tbody>
												<?php 
													$showdata = mysqli_query($con, "SELECT * FROM radcheck, member, radacct WHERE radcheck.username = member.username AND radcheck.username = radacct.username AND radcheck.username = '$username'"); 
													while ($show = mysqli_fetch_array($showdata)) { 
														$sUsername = $show['username']; ?>
													<tr class="bg-white">
														<td><?php echo $show['id']; ?></td>
														<td><?php echo $show['username']; ?></td>
														<td><?php echo $show['m_name']; ?></td>
														<td><?php echo $show['m_lastname']; ?></td>
														<td><?php echo $show['acctstarttime']; ?></td>
														<td><?php echo $show['acctstoptime']; ?></td>
														<td><?php echo $show['m_update']; ?></td>
														<td><?php echo $show['m_who']; ?></td>
													</tr>
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