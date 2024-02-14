<!--
=========================================================
* Argon Dashboard PRO - v1.2.1
=========================================================
* Product Page: #/product/argon-dashboard-pro

* Copyright 2021 Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
	<meta name="author" content="Creative Tim">
	<title>Access Panel</title>
	<!-- Favicon -->
	<link rel="icon" href="<?= base_url('assets/'); ?>img/brand/favicon.png" type="image/png">
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
	<!-- Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/nucleo/css/nucleo.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
	<!-- Argon CSS -->
	<link rel="stylesheet" href="<?= base_url('assets/'); ?>css/argon.css?v=1.2.1" type="text/css">
</head>

<body class="bg-dark">

	<div class="d-flex justify-content-md-center align-items-center vh-100">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-5 col-md-7">
					<div class="card bg-secondary border-0 mb-0">
						<div class="card-body px-lg-5 py-lg-5">
							<form method="post" action="<?= base_url('auth/index'); ?>" class="text-start">
								<div class="text-center text-muted mb-5">
									<h1 class="">Welcome!</h1>
								</div>
								<?= $this->session->flashdata('alert'); ?>
								<div class="form-group">
									<input type="text" class="form-control" id="username" name="username" placeholder="Username">
									<?= form_error('username', '<small class="text-danger mt-1 mx-2">', '</small>'); ?>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									<?= form_error('password', '<small class="text-danger mt-1 mx-2">', '</small>'); ?>
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-block my-4">Login</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Argon Scripts -->
	<!-- Core -->
	<script src="<?= base_url('assets/'); ?>vendor/jquery/dist/jquery.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/js-cookie/js.cookie.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
	<script src="<?= base_url('assets/'); ?>vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
	<!-- Argon JS -->
	<script src="<?= base_url('assets/'); ?>js/argon.js?v=1.2.1"></script>
	<!-- Demo JS - remove this in your project -->
	<script src="<?= base_url('assets/'); ?>js/demo.min.js"></script>
</body>

</html>