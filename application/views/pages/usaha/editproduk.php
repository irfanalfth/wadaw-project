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

				<div class="card-header">
					<h3 class="mb-0">Edit Produk</h3>
				</div>

				<div class="card-body">
					<form class="update-form">
						<input type="hidden" name="produk_id" value="<?= $data['id']; ?>">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group input-group-merge">
										<input class="form-control text" placeholder="Kode Produk" type="text" name="kode" value="<?= $data['kode']; ?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group input-group-merge">
										<input class="form-control text" placeholder="Nama Produk" type="text" name="nama" value="<?= $data['nama']; ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group input-group-merge">
										<input class="form-control rupiahInput" placeholder="Harga 1 Produk" type="text" name="harga_1" value="<?= $data['harga_1']; ?>">
										<div class="input-group-append">
											<span class="input-group-text"><small class="font-weight-bold">Rp</small></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group input-group-merge">
										<input class="form-control rupiahInput" placeholder="Harga 6 Produk" type="text" name="harga_6" value="<?= $data['harga_6']; ?>">
										<div class="input-group-append">
											<span class="input-group-text"><small class="font-weight-bold">Rp</small></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group input-group-merge">
										<input class="form-control rupiahInput" placeholder="Harga 3 Produk" type="text" name="harga_3" value="<?= $data['harga_3']; ?>">
										<div class="input-group-append">
											<span class="input-group-text"><small class="font-weight-bold">Rp</small></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group input-group-merge">
										<input class="form-control rupiahInput" placeholder="Harga 12 Produk" type="text" name="harga_12" value="<?= $data['harga_12']; ?>">
										<div class="input-group-append">
											<span class="input-group-text"><small class="font-weight-bold">Rp</small></span>
										</div>
									</div>
								</div>
								<div class="text-right">
									<button class="btn btn-dark" type="submit">
										Simpan
									</button>
								</div>
							</div>
						</div>
					</form>
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
			this.value = formatRupiah(this.value, '');
		});
	});

	document.addEventListener('DOMContentLoaded', function() {
		rupiahInputs.forEach(function(rupiah) {
			rupiah.value = formatRupiah(rupiah.value, '');
		});
	});

	var textInputs = document.querySelectorAll('.text');

	textInputs.forEach(function(text) {
		text.addEventListener('keyup', function(e) {
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
		return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
	}

	$('.update-form').submit(function(e) {
		e.preventDefault();

		var formData = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('usaha/updateProduk'); ?>',
			data: formData,
			success: function(response) {
				let res = JSON.parse(response);

				Swal.fire({
					icon: 'success',
					title: 'Success!',
					text: `Berhasil update produk`,
				}).then((result) => {
					if (result.isConfirmed || result.isDismissed) {
						location.replace('<?= base_url('usaha/produk') ?>');
					}
				});
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	});
</script>