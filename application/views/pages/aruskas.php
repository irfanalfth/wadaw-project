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
			<div class="card my-2">
				<div class="card-body">
					<form id="add-kas">
						<div class="form-row align-items-center">
							<div class="col-sm-12 col-md-6 col-lg-3 my-2">
								<input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" autocomplete="off">
							</div>
							<div class="col-sm-12 col-md-6 col-lg-2 my-2">
								<select name="kategori" id="kategori" class="form-control">
									<option value="" selected disabled>Kategori</option>
									<option value="in">Masuk</option>
									<option value="out">Keluar</option>
									<option value="save">Tabungan</option>
								</select>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-2 my-2">
								<select name="pembayaran" id="pembayaran" class="form-control">
									<option value="" selected disabled>Dompet</option>
									<?php foreach ($dompet as $key => $row) : ?>
										<option value="<?= $key; ?>"><?= $row; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-3 my-2">
								<input type="text" class="form-control" name="jumlah" id="rupiahInput" placeholder="Jumlah" autocomplete="off">
							</div>
							<div class="col-sm-auto col-md-12 col-lg-2 my-2 btn-block">
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

							<script>
								var rupiah = document.getElementById('rupiahInput');

								rupiah.addEventListener('keyup', function(e) {
									rupiah.value = formatRupiah(this.value, 'Rp. ');
								});

								var keterangan = document.getElementById('keterangan');

								keterangan.addEventListener('keyup', function(e) {
									keterangan.value = capitalizeFirstLetter(this.value);
								});

								function capitalizeFirstLetter(string) {
									return string.charAt(0).toUpperCase() + string.slice(1);
								}

								function formatRupiah(angka, prefix) {
									var number_string = angka.replace(/[^,\d]/g, '').toString(),
										split = number_string.split(','),
										sisa = split[0].length % 3,
										rupiah = split[0].substr(0, sisa),
										ribuan = split[0].substr(sisa).match(/\d{3}/gi);

									if (ribuan) {
										separator = sisa ? '.' : '';
										rupiah += separator + ribuan.join('.');
									}

									rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
									return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
								}

								$(document).ready(function() {
									$('#add-kas').submit(function(e) {
										e.preventDefault();

										var formData = $(this).serialize();

										$.ajax({
											type: 'POST',
											url: '<?= base_url('keuangan/addKas'); ?>',
											data: formData,
											success: function(response) {
												let res = JSON.parse(response);

												Swal.fire({
													icon: 'success',
													title: 'Success!',
													text: `Arus kas berhasil ditambah`,
												}).then((result) => {
													if (result.isConfirmed || result.isDismissed) {
														location.reload();
													}
												});
											},
											error: function(xhr, status, error) {
												console.error(xhr.responseText);
											}
										});
									});

									$('.delete-btn').click(function() {
										var dataId = $(this).data('id');

										Swal.fire({
											title: 'Anda yakin ingin menghapus?',
											text: '',
											icon: 'warning',
											showCancelButton: true,
											confirmButtonText: 'Yes'
										}).then((result) => {
											if (result.isConfirmed) {
												$.ajax({
													type: 'POST',
													url: '<?= base_url('keuangan/deleteKas'); ?>',
													data: {
														id: dataId
													},
													success: function(response) {
														Swal.fire('Berhasil menghapus data!', '', 'success').then((result) => {
															if (result.isConfirmed || result.isDismissed) {
																location.reload();
															}
														});
													},
													error: function(xhr, status, error) {
														console.error(xhr.responseText);
														Swal.fire('Error!', 'Failed to delete data.', 'error');
													}
												});
											}
										});
									});
								});

								document.getElementById("kategori").addEventListener("change", function() {
									var selectedValue = this.value;

									if (selectedValue === "need") {
										$.ajax({
											type: "POST",
											url: "<?= base_url('keuangan/getKebutuhan'); ?>",
											data: {
												kategori: selectedValue
											},
											dataType: "json",
											success: function(response) {
												document.getElementById("keterangan").value = "Kebutuhan (<?= date('M') ?>)";
												document.getElementById("rupiahInput").value = response;
											}
										});
									} else {
										document.getElementById("keterangan").value = "";
										document.getElementById("rupiahInput").value = "";
									}
								});
							</script>
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