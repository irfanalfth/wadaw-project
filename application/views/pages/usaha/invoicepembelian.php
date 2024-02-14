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
			<div class="card">
				<div class="card-body p-5">
					<div class="row">
						<div class="col-md-6">
							<div class="text-muted mb-2">Tanggal Pembelian</div>
							<strong><?= date("d M Y"); ?></strong>
						</div>
					</div>
					<table class="table border-bottom table-flush mt-4">
						<thead class="thead-light">
							<tr>
								<th>kode</th>
								<th>produk</th>
								<th>jumlah</th>
								<th class="text-right">harga</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($data['produk'] as $key => $row) : ?>
								<tr>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= $row['kode']; ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= $row['nama']; ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= $row['jumlah']; ?>
									</td>
									<td class="align-middle text-right mb-0 text-sm font-weight-600">
										<?= rupiah($row['harga']); ?>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>

					<div class="mt-4">
						<div class="d-flex justify-content-end mt-3 mr-3">
							<h3 class="mx-3">Total : </h3>
							<h3 class="text-primary"><?= rupiah($data['total']); ?></h3>
						</div>
						<div class="d-flex justify-content-end mt-3 mr-3">
							<form action="" method="post">
								<input type="hidden" name="data" value="<?= serialize($data['produk']); ?>">
								<button type="submit" class="btn btn-success">Simpan</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer class="footer pt-0">
		<div class="row align-items-center justify-content-lg-between">
			<div class="col-lg-6">
				<div class="copyright text-center  text-lg-left  text-muted">
					&copy; <?= date("Y"); ?> <a href="#" class="font-weight-bold ml-1" target="_blank">Our Site</a>
				</div>
			</div>
		</div>
	</footer>
</div>