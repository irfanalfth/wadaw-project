<?php
$dompet = [
	'tunai' => 'Tunai',
	'dana' => 'DANA',
	'blu' => 'Blu by BCA',
	'seabank' => 'Seabank',
	'bri' => 'BRI',
	'gopay' => 'Gopay',
	'shopeepay' => 'ShopeePay'
];
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
		</div>
	</div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
	<!-- Table -->
	<div class="row">
		<div class="col">
			<div class="card mb-3">
				<div class="card-body">
					<form action="<?= base_url('keuangan/perbulaan'); ?>" method="post">
						<div class="form-row align-items-center">
							<div class="col">
								<?php $tanggalSaatIni = date('Y-m');

								if (isset($_POST['tahunBulan'])) {
									$tanggalSaatIni = htmlspecialchars($_POST['tahunBulan']);
								} ?>
								<input type="month" class="form-control" name="tahunBulan" id="tahunBulan" autocomplete="off" value="<?= $tanggalSaatIni;  ?>">
							</div>
							<div class="col-auto">
								<button type="submit" class="btn btn-default btn-block">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="card">
				<div class="table-responsive py-4">
					<table class="table table-flush" id="datatable-basic">
						<thead class="thead-light">
							<tr>
								<th>tanggal</th>
								<th>keterangan</th>
								<th>kategori</th>
								<th>dompet</th>
								<th>jumlah</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data as $key => $row) : ?>
								<tr>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= $row['tanggal']; ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= $row['keterangan']; ?>
									</td>
									<td>
										<span class="badge badge-dot mr-4">
											<?php if ($row['kategori'] === 'in') : ?>
												<i class="bg-success"></i>
											<?php elseif ($row['kategori'] === 'out') : ?>
												<i class="bg-danger"></i>
											<?php elseif ($row['kategori'] === 'save') : ?>
												<i class="bg-info"></i>
											<?php else : ?>
												<i class="bg-yellow"></i>
											<?php endif; ?>
											<span class=" status font-weight-600">
												<?php if ($row['kategori'] === 'in') : ?>
													Masuk
												<?php elseif ($row['kategori'] === 'out') : ?>
													Keluar
												<?php elseif ($row['kategori'] === 'save') : ?>
													Tabungan
												<?php else : ?>
													Kebutuhan
												<?php endif; ?>
											</span>
										</span>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= searchInArray($row['dompet'], $dompet); ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600 <?= $row['kategori'] === 'in' ? 'text-success' : 'text-red'; ?>">
										<?= ($row['kategori'] === 'in' ? '+ ' : '- '); ?>
										<?= rupiah($row['jumlah']); ?>
									</td>
									<td class="text-right">
										<div class="dropdown">
											<a class="btn btn-sm btn-icon-only text-black-50" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-ellipsis-v"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
												<a data-id="<?= $row['id'] ?>" class="dropdown-item text-red font-weight-bold delete-btn" href="#">Delete</a>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer class=" footer pt-0">
		<div class="row align-items-center justify-content-lg-between">
			<div class="col-lg-6">
				<div class="copyright text-center  text-lg-left  text-muted">
					&copy; <?= date("Y"); ?> <a href="#" class="font-weight-bold ml-1" target="_blank">Our Site</a>
				</div>
			</div>
		</div>
	</footer>
</div>