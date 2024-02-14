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
				<div class="col-lg-6 col-5 text-right">
					<button class="btn btn-white" data-toggle="modal" data-target="#modalProduk">
						Produk
					</button>
					<!-- <button class="btn btn-white" data-toggle="modal" data-target="#addStok">
						Tambah Stok
					</button> -->
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
				<div class="table-responsive py-4">
					<table class="table table-flush" id="datatable-basic">
						<thead class="thead-light">
							<tr>
								<th>kode</th>
								<th>nama</th>
								<th>Jumlah</th>
								<th>Harga Beli</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($data as $key => $row) : ?>
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
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= rupiah($row['harga_beli']); ?>
									</td>
									<td class="align-middle font-weight-bolder">
										<button data-id="<?= $row['id'] ?>" class="btn btn-danger btn-icon-only rounded-circle delete-btn">
											<span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
										</button>
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

<div class="modal fade" id="addStok" tabindex="-1" role="dialog" aria-labelledby="addStokLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="text-center pt-4">
				<h2>Tambah Stok</h2>
			</div>
			<div class="modal-body px-5 pb-5">
				<div class="card bg-secondary border-0 mb-0">
					<form class="add-form">
						<div class="form-group">
							<select class="form-control" data-toggle="select" name="produk_id" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
								<option selected disabled>Produk</option>
								<?php foreach ($produk as $key => $row) : ?>
									<option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="form-group">
							<input class="form-control" type="number" name="jumlah" placeholder="Jumlah">
						</div>
						<button type="submit" class="btn btn-primary btn-block">Simpan</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addProduk" tabindex="-1" role="dialog" aria-labelledby="addProdukLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="text-center pt-4">
				<h2>Tambah Produk</h2>
			</div>
			<div class="modal-body px-5 pb-5">
				<div class="card bg-secondary border-0 mb-0">
					<form class="add-form">
						<div class=" form-group">
							<input class="form-control keterangan" type="text" id="keterangan" name="kode" placeholder="Kode">
						</div>
						<div class="form-group">
							<input class="form-control keterangan" type="text" id="keterangan" name="nama" placeholder="Nama">
						</div>
						<button type="submit" class="btn btn-primary btn-block">Simpan</button>
						<button type="submit" class="btn btn-dark btn-block" data-toggle="modal" data-target="#modalProduk" data-dismiss="modal">Kembali</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="modalProdukLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="text-center pt-4">
				<h2>Daftar Produk</h2>
			</div>
			<div class="modal-body px-5 pb-5">
				<div class="card bg-secondary border-0 mb-0">
					<form class="update-form">
						<div class="form-group">
							<form>
								<select class="form-control" data-toggle="select" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
									<option selected disabled>Produk</option>
									<?php foreach ($produk as $key => $row) : ?>
										<option value="<?= $row['id']; ?>"><?= $row['kode'] . ' | ' . $row['nama']; ?></option>
									<?php endforeach ?>
								</select>
							</form>
						</div>
						<button type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addProduk" data-dismiss="modal">Tambah Produk</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	var rupiahInputs = document.querySelectorAll('.rupiahInput');

	rupiahInputs.forEach(function(rupiah) {
		rupiah.addEventListener('keyup', function(e) {
			this.value = formatRupiah(this.value, 'Rp. ');
		});
	});

	var keteranganInputs = document.querySelectorAll('.keterangan');

	keteranganInputs.forEach(function(keterangan) {
		keterangan.addEventListener('keyup', function(e) {
			this.value = capitalizeFirstLetter(this.value);
		});
	});

	function capitalizeFirstLetter(string) {
		return string.toUpperCase();
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

	$('.update-form').submit(function(e) {
		e.preventDefault();

		var formData = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('usaha/addStok'); ?>',
			data: formData,
			success: function(response) {
				let res = JSON.parse(response);

				Swal.fire({
					icon: 'success',
					title: 'Success!',
					text: `Berhasil tambah stok`,
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

	$('.add-form').submit(function(e) {
		e.preventDefault();

		var formData = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('usaha/addProduk'); ?>',
			data: formData,
			success: function(response) {
				let res = JSON.parse(response);

				Swal.fire({
					icon: 'success',
					title: 'Success!',
					text: `Berhasil tambah produk`,
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
					url: '<?= base_url('usaha/deleteStok'); ?>',
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
</script>