<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
	<div class="scrollbar-inner">
		<div class="sidenav-header  d-flex  align-items-center">
			<a class="navbar-brand" href="javascript:void(0)">
				<img src="<?= base_url('assets/'); ?>img/brand/panel.png" class="navbar-brand-img" alt="...">
			</a>
			<div class=" ml-auto ">
				<div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
					<div class="sidenav-toggler-inner">
						<i class="sidenav-toggler-line"></i>
						<i class="sidenav-toggler-line"></i>
						<i class="sidenav-toggler-line"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="navbar-inner">
			<div class="collapse navbar-collapse" id="sidenav-collapse-main">
				<h6 class="navbar-heading p-0 text-muted">
					<span class="docs-normal">Keuangan</span>
					<span class="docs-mini">M</span>
				</h6>
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(2) === 'dashboard' ? 'active font-weight-400' : ''; ?>" href="<?= base_url('keuangan/dashboard'); ?>">
							<i class="ni ni-world-2 text-green"></i>
							<span class="nav-link-text">Dashboard</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(1) === 'keuangan' && $this->uri->segment(2) === null ? 'active font-weight-400' : ''; ?>" href="#navbar-dashboards" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
							<i class="ni ni-books text-primary"></i>
							<span class="nav-link-text">Arus Kas</span>
						</a>
						<div class="collapse show" id="navbar-dashboards">
							<ul class="nav nav-sm flex-column">
								<li class="nav-item <?= $this->uri->segment(1) === 'keuangan' && $this->uri->segment(2) === null ? 'active' : ''; ?>">
									<a href="<?= base_url('keuangan'); ?>" class="nav-link">
										<span class="sidenav-mini-icon"> N </span>
										<span class="sidenav-normal"> Catatan Bulan Ini </span>
									</a>
								</li>
								<li class="nav-item <?= $this->uri->segment(2) === 'perbulan' ? 'active' : ''; ?>">
									<a href="<?= base_url('keuangan/perbulan'); ?>" class="nav-link">
										<span class="sidenav-mini-icon"> M </span>
										<span class="sidenav-normal"> Catatan per Bulan </span>
									</a>
								</li>
							</ul>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(2) === 'kebutuhan' ? 'active font-weight-400' : ''; ?>" href="<?= base_url('keuangan/kebutuhan'); ?>">
							<i class="ni ni-tag text-default"></i>
							<span class="nav-link-text">Kebutuhan</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(2) === 'tabungan' ? 'active font-weight-400' : ''; ?>" href="<?= base_url('keuangan/tabungan'); ?>">
							<i class="ni ni-trophy text-yellow"></i>
							<span class="nav-link-text">Tabungan</span>
						</a>
					</li>
				</ul>

				<h6 <?= $this->session->userdata('username') === 'pan' ? 'hidden' : ''; ?> class="navbar-heading p-0 text-muted mt-3">
					<span class="docs-normal">Usaha</span>
					<span class="docs-mini">U</span>
				</h6>
				<ul <?= $this->session->userdata('username') === 'pan' ? 'hidden' : ''; ?> class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link <?= $this->uri->segment(1) === 'usaha' ? 'active font-weight-400' : ''; ?>" href="#navbar-usaha" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-usaha">
							<i class="ni ni-spaceship text-pink"></i>
							<span class="nav-link-text">PRM Luxury</span>
						</a>
						<div class="collapse show" id="navbar-usaha">
							<ul class="nav nav-sm flex-column">
								<li class="nav-item <?= $this->uri->segment(1) === 'usaha' && $this->uri->segment(2) === null ? 'active' : ''; ?>">
									<a href="<?= base_url('usaha'); ?>" class="nav-link">
										<span class="sidenav-mini-icon"> D </span>
										<span class="sidenav-normal"> Dashboard </span>
									</a>
								</li>
								<li class="nav-item <?= $this->uri->segment(2) === 'stok' ? 'active' : ''; ?>">
									<a href="<?= base_url('usaha/stok'); ?>" class="nav-link">
										<span class="sidenav-mini-icon"> P </span>
										<span class="sidenav-normal"> Stok </span>
									</a>
								</li>
								<li class="nav-item <?= $this->uri->segment(2) === 'penjualan' ? 'active' : ''; ?>">
									<a href="<?= base_url('usaha/penjualan'); ?>" class="nav-link">
										<span class="sidenav-mini-icon"> P </span>
										<span class="sidenav-normal"> Penjualan </span>
									</a>
								</li>
								<li class="nav-item <?= $this->uri->segment(2) === 'pembelian' ? 'active' : ''; ?>">
									<a href="<?= base_url('usaha/pembelian'); ?>" class="nav-link">
										<span class="sidenav-mini-icon"> P </span>
										<span class="sidenav-normal"> Pembelian </span>
									</a>
								</li>
							</ul>
						</div>
					</li>
				</ul>

				<hr class="my-2">

				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('auth/logout'); ?>">
							<i class="ni ni-cloud-download-95 text-red"></i>
							<span class="nav-link-text text-dark font-weight-bold">Logout</span>
						</a>
					</li>
				</ul>

			</div>
		</div>
	</div>
</nav>