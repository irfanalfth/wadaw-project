<!-- Main content -->
<div class="main-content" id="panel">
	<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav align-items-center  ml-md-auto ">
					<li class="nav-item d-xl-none">
						<div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
							<div class="sidenav-toggler-inner">
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
								<i class="sidenav-toggler-line"></i>
							</div>
						</div>
					</li>
				</ul>
				<ul class="navbar-nav align-items-center ml-auto ml-md-0">
					<li class="nav-item dropdown">
						<a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<div class="media align-items-center">
								<div class="media-body  ml-2  d-none d-lg-block">
									<span class="mb-0 text-sm  font-weight-bold"><?= $this->session->userdata('username'); ?></span>
								</div>
							</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
