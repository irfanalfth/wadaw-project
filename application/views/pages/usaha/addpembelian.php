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
						<div class="col-6">
							<div class="text-muted mb-2">Tanggal Pembelian</div>
							<strong><?= date("d M Y"); ?></strong>
						</div>
					</div>
					<form class="postProduk">
						<table class="table border-bottom table-flush mt-4" id="dynamicAddRemove">
							<thead class="thead-light">
								<tr>
									<th width="10%">#</th>
									<th width="45%">produk</th>
									<th width="15%">jumlah</th>
									<th width="30%" class="text-right">harga</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<button type="button" id="dynamic-ar" class="btn btn-primary btn-icon-only rounded-circle">
											<span class="btn-inner--icon"><i class="fas fa-plus"></i></span>
										</button>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<select class="form-control" data-toggle="select" name="produk[0]" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
											<option selected disabled>Produk</option>
											<?php foreach ($data as $key => $row) : ?>
												<option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
											<?php endforeach ?>
										</select>
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
										<input class="form-control" type="number" name="jumlah[0]" placeholder="Jumlah">
									</td>
									<td class="align-middle text-right mb-0 text-sm font-weight-600">
										<input class="form-control rupiahInput" style="text-align: right;" type="text" name="harga[0]" placeholder="Harga Beli">
									</td>
								</tr>
							</tbody>
						</table>

						<div class="mt-4">
							<div class="d-flex justify-content-end mt-3 mr-3">
								<button type="submit" class="btn btn-dark" data-toggle="modal" data-target="#modalProduk">
									Selanjutnya
								</button>
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

<div class="modal fade" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="modalProdukLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="p-5">
				<div class="row align-items-center">
					<div class="col-md-6">
						<strong>Invoice</strong>
					</div>
					<div class="col-md-6 text-right">
						<form class="save-db">
							<input type="hidden" name="datas">
							<button type="submit" class="btn btn-success">Simpan</button>
						</form>
					</div>
				</div>
				<table class="table border-bottom table-flush mt-4" id="dynamicAddRemoveProduk">
					<thead class="thead-light">
						<tr>
							<th>kode</th>
							<th>produk</th>
							<th>jumlah</th>
							<th class="text-right">harga</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>

				<div class="mt-4">
					<div class="d-flex justify-content-end mt-3 mr-3">
						<h3 class="mx-3">Total : </h3>
						<h3 class="text-primary total"></h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('.postProduk').submit(function(e) {
		e.preventDefault();

		var formData = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('usaha/addProdukPembelian'); ?>',
			data: formData,
			success: function(response) {
				let res = JSON.parse(response);

				$("#dynamicAddRemoveProduk tbody").empty();
				$(".total").empty();

				res.data.produk.forEach(p => {
					var newRow = `<tr>
									<td class="align-middle mb-0 text-sm font-weight-600">
									${p.kode}
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
									${p.nama}
									</td>
									<td class="align-middle mb-0 text-sm font-weight-600">
									${p.jumlah}
									</td>
									<td class="align-middle text-right mb-0 text-sm font-weight-600">
									Rp. ${formatRupiah(p.harga)}
									</td>
								</tr>`;

					$("#dynamicAddRemoveProduk").append(newRow);
				});

				$(".total").append(formatRupiah(res.data.total.toString(), 'Rp. '));

				$('input[name="datas"]').val(JSON.stringify(res.data.produk));
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	});

	$('.save-db').submit(function(e) {
		e.preventDefault();

		var formData = $(this).serialize();

		$.ajax({
			type: 'POST',
			url: '<?= base_url('usaha/addPembelianDB'); ?>',
			data: formData,
			success: function(response) {
				let res = JSON.parse(response);

				Swal.fire({
					icon: 'success',
					title: 'Success!',
					text: `Berhasil tambah pembelian`,
				}).then((result) => {
					if (result.isConfirmed || result.isDismissed) {
						location.replace('<?= base_url('usaha/pembelian') ?>');
					}
				});
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	});
</script>


<script>
	var rupiahInputs = document.querySelectorAll('.rupiahInput');

	$(document).on('keyup', '.rupiahInput', function(e) {
		this.value = formatRupiah(this.value, 'Rp. ');
	});

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
</script>

<script type="text/javascript">
	var i = 0;

	$("#dynamic-ar").click(function() {
		++i;

		var newRow = `<tr>
						<td class="align-middle mb-0 text-sm font-weight-600">
							<button type="button" class="btn btn-danger btn-icon-only remove-input-field rounded-circle">
								<span class="btn-inner--icon"><i class="fas fa-trash"></i></span>
							</button>
						</td>
						<td class="align-middle mb-0 text-sm font-weight-600">
							<select class="form-control dynamic-select" name="produk[${i}]" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
								<option selected disabled>Produk</option>
								<?php foreach ($data as $key => $row) : ?>
									<option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
								<?php endforeach ?>
							</select>
						</td>
						<td class="align-middle mb-0 text-sm font-weight-600">
							<input class="form-control" type="number" name="jumlah[${i}]" placeholder="Jumlah">
						</td>
						<td class="align-middle text-right mb-0 text-sm font-weight-600">
							<input class="form-control rupiahInput" style="text-align: right;" type="text" name="harga[${i}]" placeholder="Harga Beli">
						</td>
					</tr>`;

		$("#dynamicAddRemove").append(newRow);

		$('.dynamic-select').select2();
	});

	$(document).on('click', '.remove-input-field', function() {
		$(this).parents('tr').remove();
	});
</script>