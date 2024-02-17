<div class="header bg-primary pb-6">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<nav aria-label="breadcrumb" class="d-none d-md-inline-block">
						<ol class="breadcrumb breadcrumb-links breadcrumb-dark">
							<li class="breadcrumb-item">
								<a href="#">
									<i class="ni ni-app text-yellow"></i>
								</a>
							</li>
							<li class="breadcrumb-item active text-white" aria-current="page"><?= $title; ?></li>
						</ol>
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-12">
					<div class="card card-stats">
						<!-- Card body -->
						<div class="card-body my-3">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">Saldo Kas</h5>
									<span class="h1 font-weight-bold mb-0"><?= rupiah($data['saldo']['saldo_kas']); ?></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-dark text-white rounded-circle shadow">
										<i class="fas fa-coins"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12">
					<div class="card card-stats">
						<!-- Card body -->
						<div class="card-body my-3">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">Saldo Tabungan</h5>
									<span class="h1 font-weight-bold mb-0"><?= rupiah($data['saldo']['saldo_tabungan']); ?></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
										<i class="fas fa-wallet"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12">
					<div class="card card-stats">
						<!-- Card body -->
						<div class="card-body my-3">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">Total Pemasukan</h5>
									<span class="h1 font-weight-bold mb-0"><?= rupiah($data['arus_kas']['in']['total']); ?></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-success text-white rounded-circle shadow">
										<i class="fas fa-arrow-down"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12">
					<div class="card card-stats">
						<!-- Card body -->
						<div class="card-body my-3">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">Total Pengeluaran</h5>
									<span class="h1 font-weight-bold mb-0"><?= rupiah($data['arus_kas']['out']['total']); ?></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-red text-white rounded-circle shadow">
										<i class="fas fa-arrow-up"></i>
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