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
					<a href="<?= base_url('/usaha/addPenjualan'); ?>" class="btn btn-white">
						Tambah Penjualan
					</a>
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
								<th>tanggal</th>
								<th>pembelian</th>
								<th>pelanggan</th>
								<th>total pembelian</th>
								<th>keterangan</th>
								<th>status</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($data as $key => $row) : ?>
								<tr>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= date("d M Y", strtotime($row['tanggal'])); ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<span class="badge badge-dot mr-4">
											<i class="bg-<?= $row['pembelian'] === 'ONLINE' ? 'primary' : 'warning' ?>"></i>
											<span class="status font-weight-600"><?= $row['pembelian']; ?></span>
										</span>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= strtoupper($row['pelanggan']); ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600 text-primary">
										<?= rupiah($row['total_penjualan']); ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<?= $row['keterangan']; ?>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<span class="badge badge-dot mr-4">
											<i class="bg-<?= $row['status_pembayaran'] === 'LUNAS' ? 'success' : 'danger' ?>"></i>
											<span class="status font-weight-600"><?= $row['status_pembayaran']; ?></span>
										</span>
									</td>
									<td class="align-middle font-weight-bolder">
										<a href="<?= base_url('usaha/detailPenjualan/' . $row['id']); ?>" class="btn btn-dark btn-icon-only rounded-circle">
											<span class="btn-inner--icon"><i class="fas fa-info"></i></span>
										</a>
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

	$('.add-form').submit(function(e) {
		e.preventDefault();

		var formData = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('keuangan/addKebutuhan'); ?>',
			data: formData,
			success: function(response) {
				let res = JSON.parse(response);

				Swal.fire({
					icon: 'success',
					title: 'Success!',
					text: `Berhasil tambah kebutuhan`,
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
					url: '<?= base_url('keuangan/deleteKebutuhan'); ?>',
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