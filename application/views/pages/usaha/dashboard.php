<div class="header bg-primary">
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
			<!-- Card stats -->
			<div class="row">
				<div class="col-xl-4 col-md-6">
					<div class="card card-stats">
						<!-- Card body -->
						<div class="card-body mt-3">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">Total Pembelian</h5>
									<span class="h1 font-weight-bold mb-0"><?= rupiah($data['total_pembelian']['total_pembelian']); ?></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-red text-white rounded-circle shadow">
										<i class="ni ni-active-40"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-sm">
								<span class="text-red mr-2 font-weight-bold"><?= $data['total_pembelian']['produk_beli']; ?></span>
								<span class="text-nowrap font-weight-400">Produk Masuk Bulan Ini</span>
							</p>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-6">
					<div class="card card-stats">
						<!-- Card body -->
						<div class="card-body mt-3">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">Total Penjualan</h5>
									<span class="h1 font-weight-bold mb-0"><?= rupiah($data['total_penjualan']['total_penjualan']); ?></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-success text-white rounded-circle shadow">
										<i class="ni ni-active-40"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-sm">
								<span class="text-success mr-2 font-weight-bold"><?= $data['total_penjualan']['produk_jual']; ?></span>
								<span class="text-nowrap font-weight-400">Produk Terjual Bulan Ini</span>
							</p>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-6">
					<div class="card card-stats">
						<!-- Card body -->
						<div class="card-body mt-3">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">Total Penghasilan</h5>
									<span class="h1 font-weight-bold mb-0 <?= $data['total_penghasilan'] < 0 ? 'text-danger' : ''; ?>"><?= rupiah($data['total_penghasilan']); ?></span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-blue text-white rounded-circle shadow">
										<i class="ni ni-active-40"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-sm">
								<span class="text-blue mr-2 font-weight-bold">Bulan Ini</span>
								<span class="text-nowrap font-weight-400"></span>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-4">
					<div class="card">
						<div class="card-header border-0">
							<div class="row align-items-center">
								<div class="col">
									<h3 class="mb-0">Stok Produk</h3>
								</div>
							</div>
						</div>
						<div class="table-responsive">

							<table class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th scope="col">Produk</th>
										<th scope="col">Harga Beli</th>
										<th scope="col">Jumlah</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data['produk_stok'] as $key => $value) : ?>
										<tr>
											<td scope="row">
												<div class="mb-0 font-weight-bold">
													<?= $value['nama']; ?>
												</div>
												<span>
													<?= strtoupper($value['kode']); ?>
												</span>
											</td>
											<th class="text-primary">
												<?= rupiah($value['harga_beli']); ?>
											</th>
											<td>
												<?php if ($value['jumlah'] === "0") : ?>
													<span class="badge badge-dot mr-4">
														<i class="bg-red"></i>
														<span>Stok Habis</span>
													</span>
												<?php else : ?>
													<?= $value['jumlah']; ?>
												<?php endif ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-xl-4">
					<div class="card">
						<div class="card-header border-0">
							<div class="row align-items-center">
								<div class="col">
									<h3 class="mb-0">Penjualan Terakhir</h3>
								</div>
							</div>
						</div>
						<div class="table-responsive">

							<table class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th>tanggal</th>
										<th>total pembelian</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($data['penjualan'] as $key => $row) : ?>
										<tr>
											<td>
												<?= date("d M Y", strtotime($row['tanggal'])); ?>
											</td>
											<td class="text-primary">
												<?= rupiah($row['total_penjualan']); ?>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-xl-4">
					<div class="card">
						<div class="card-header border-0">
							<div class="row align-items-center">
								<div class="col">
									<h3 class="mb-0">Pembelian Terakhir</h3>
								</div>
							</div>
						</div>
						<div class="table-responsive">

							<table class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th>tanggal</th>
										<th>total pembelian</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($data['pembelian'] as $key => $row) : ?>
										<tr>
											<td>
												<?= date("d M Y", strtotime($row['tanggal_pembelian'])); ?>
											</td>
											<td class="text-primary">
												<?= rupiah($row['total_pembelian']); ?>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>