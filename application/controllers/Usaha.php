<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usaha extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!is_logged_in()) {
			redirect('auth');
		}
	}

	public function index()
	{
		$total_penjualan = $this->db->select('SUM(penjualan_detail.harga * penjualan_detail.jumlah) as total_penjualan, SUM(penjualan_detail.jumlah) as produk_jual')
			->from('penjualan_detail')
			->join('penjualan', 'penjualan_detail.penjualan_id = penjualan.id')
			->join('produk', 'penjualan_detail.produk_id = produk.id')
			->where('DATE(penjualan.tanggal) >=', date('Y-m-01'))
			->where('DATE(penjualan.tanggal) <=', date('Y-m-t'))
			->where("penjualan.status_pembayaran = 'LUNAS'")
			->get()
			->row_array();
		$total_pembelian = $this->db->select('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total_pembelian, SUM(pembelian_detail.jumlah) as produk_beli')
			->from('pembelian_detail')
			->join('pembelian', 'pembelian_detail.pembelian_id = pembelian.id')
			->join('produk', 'pembelian_detail.produk_id = produk.id')
			->where('DATE(pembelian.tanggal) >=', date('Y-m-01'))
			->where('DATE(pembelian.tanggal) <=', date('Y-m-t'))
			->get()
			->row_array();

		$total_penghasilan = 0;

		$keuntungan = $this->db->select('CEIL(SUM(penjualan_detail.jumlah * penjualan_detail.harga) / 100) * 100 - SUM(penjualan_detail.jumlah	) * CEIL(SUM(pembelian_detail.jumlah * pembelian_detail.harga) / SUM(pembelian_detail.jumlah) / 100) * 100  as keuntungan')
			->from('penjualan_detail')
			->join('penjualan', 'penjualan_detail.penjualan_id = penjualan.id')
			->join('pembelian_detail', 'penjualan_detail.produk_id = pembelian_detail.produk_id')
			->join('produk', 'penjualan_detail.produk_id = produk.id')
			->join('produk_stok', 'produk.id = produk_stok.produk_id', 'inner')
			->group_by('produk.nama')
			->where('DATE(penjualan.tanggal) >=', date('Y-m-01'))
			->where('DATE(penjualan.tanggal) <=', date('Y-m-t'))
			->get()
			->result_array();

		foreach ($keuntungan as $item) {
			$total_penghasilan += intval($item["keuntungan"]);
		}

		$data = [
			'pages' => 'usaha/dashboard',
			'title' => 'Dashboard',
			'data' => [
				'total_penjualan' => $total_penjualan,
				'total_pembelian' => $total_pembelian,
				'total_penghasilan' => $total_penghasilan,

				'produk_stok' => $this->db->select('produk.id, produk.nama, CEIL(SUM(pembelian_detail.jumlah * pembelian_detail.harga) / SUM(pembelian_detail.jumlah) / 100) * 100 as harga_beli, produk_stok.jumlah, produk.kode')
					->from('pembelian_detail')
					->join('pembelian', 'pembelian_detail.pembelian_id = pembelian.id')
					->join('produk', 'pembelian_detail.produk_id = produk.id')
					->join('produk_stok', 'produk.id = produk_stok.produk_id', 'inner')
					->group_by('produk.id, produk.nama, produk_stok.jumlah')
					->order_by('produk_stok.jumlah', 'asc')
					->limit(5)
					->get()
					->result_array(),

				'penjualan' => $this->db->select('COUNT(DISTINCT produk.id) as jenis_produk, SUM(penjualan_detail.harga * penjualan_detail.jumlah) as total_penjualan, SUM(penjualan_detail.jumlah) as jumlah_penjualan, penjualan.*')
					->from('penjualan_detail')
					->join('penjualan', 'penjualan_detail.penjualan_id = penjualan.id')
					->join('produk', 'penjualan_detail.produk_id = produk.id')
					->group_by('penjualan.id')
					->order_by('penjualan.tanggal', 'DESC')
					->limit(5)
					->get()
					->result_array(),
				'pembelian' => $this->db->select('pembelian.tanggal as tanggal_pembelian, COUNT(DISTINCT produk.id) as jenis_produk, SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total_pembelian, SUM(pembelian_detail.jumlah) as jumlah_pembelian, pembelian.id')
					->from('pembelian_detail')
					->join('pembelian', 'pembelian_detail.pembelian_id = pembelian.id')
					->join('produk', 'pembelian_detail.produk_id = produk.id')
					->group_by('pembelian.id')
					->order_by('pembelian.tanggal', 'DESC')
					->limit(5)
					->get()
					->result_array()
			]
		];

		$this->load->view('layouts/main', $data);
	}

	public function stok()
	{
		$data = [
			'pages' => 'usaha/stok',
			'title' => 'Stok',
			'data' => $this->db->select('produk.id, produk.nama, CEIL(SUM(pembelian_detail.jumlah * pembelian_detail.harga) / SUM(pembelian_detail.jumlah) / 100) * 100 as harga_beli, produk_stok.jumlah, produk.kode')
				->from('pembelian_detail')
				->join('pembelian', 'pembelian_detail.pembelian_id = pembelian.id')
				->join('produk', 'pembelian_detail.produk_id = produk.id')
				->join('produk_stok', 'produk.id = produk_stok.produk_id', 'inner')
				->group_by('produk.id, produk.nama, produk_stok.jumlah')
				->get()
				->result_array(),
			'produk' => $this->db->get('produk')->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function addProduk()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();

			$this->db->insert('produk', [
				'kode' => $data['kode'],
				'nama' => $data['nama'],
			]);

			$this->db->insert('produk_stok', [
				'produk_id' => $this->db->insert_id(),
				'jumlah' => 0,
			]);

			echo json_encode([
				'status'  => 200,
				'message' => 'Success insert into produk',
				'data'    => []
			]);
		} else {
			echo json_encode([
				'status'  => 400,
				'message' => 'Bad Request!!!',
				'data'    => []
			]);
		}
	}

	public function addStok()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();

			$oldData = $this->db->get_where('produk_stok', ['produk_id' => $data['produk_id']])->row_array();

			if ($oldData) {
				$newJumlah = $oldData['jumlah'] + $data['jumlah'];

				$this->db->update('produk_stok', ['jumlah' => $newJumlah], ['produk_id' => $data['produk_id']]);

				echo json_encode([
					'status'  => 200,
					'message' => 'Success insert into produk',
					'data'    => []
				]);
			} else {
				echo json_encode([
					'status'  => 400,
					'message' => 'Bad Request!!!',
					'data'    => []
				]);
			}
		} else {
			echo json_encode([
				'status'  => 400,
				'message' => 'Bad Request!!!',
				'data'    => []
			]);
		}
	}

	public function deleteStok()
	{
		if ($this->input->is_ajax_request()) {

			$data = $this->input->post();

			$this->db->delete('produk_stok', ['produk_id' => $data['id']]);
			$this->db->delete('produk', ['id' => $data['id']]);

			echo json_encode([
				'status'  => 200,
				'message' => 'Success deleted kebutuhan',
				'data'    => $data
			]);
		} else {
			echo json_encode([
				'status'  => 400,
				'message' => 'Bad Request!!!',
				'data'    => []
			]);
		}
	}

	public function pembelian()
	{
		$data = [
			'pages' => 'usaha/pembelian',
			'title' => 'Pembelian',
			'data' => $this->db->select('pembelian.tanggal as tanggal_pembelian, COUNT(DISTINCT produk.id) as jenis_produk, SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total_pembelian, SUM(pembelian_detail.jumlah) as jumlah_pembelian, pembelian.id')
				->from('pembelian_detail')
				->join('pembelian', 'pembelian_detail.pembelian_id = pembelian.id')
				->join('produk', 'pembelian_detail.produk_id = produk.id')
				->group_by('pembelian.id')
				->get()
				->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function detailPembelian($pembelian_id)
	{
		$data = [
			'pages' => 'usaha/detailpembelian',
			'title' => 'Detail Pembelian',
			'data' => $this->db->select('produk.nama as nama_produk, produk.kode as kode_produk, pembelian.tanggal as tanggal_pembelian, pembelian_detail.harga as harga_beli, pembelian_detail.jumlah as jumlah_pembelian')
				->from('pembelian_detail')
				->join('pembelian', 'pembelian_detail.pembelian_id = pembelian.id')
				->join('produk', 'pembelian_detail.produk_id = produk.id')
				->where('pembelian_detail.pembelian_id', $pembelian_id)
				->get()->result_array(),
			'detail' => $this->db->select('pembelian.tanggal as tanggal_pembelian, COUNT(DISTINCT produk.id) as jenis_produk, SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total_pembelian, SUM(pembelian_detail.jumlah) as jumlah_pembelian, pembelian.id')
				->from('pembelian_detail')
				->join('pembelian', 'pembelian_detail.pembelian_id = pembelian.id')
				->join('produk', 'pembelian_detail.produk_id = produk.id')
				->group_by('pembelian.id')
				->where('pembelian_detail.pembelian_id', $pembelian_id)
				->get()
				->row_array()

		];



		$this->load->view('layouts/main', $data);
	}

	public function addPembelian()
	{
		$data = [
			'pages' => 'usaha/addpembelian',
			'title' => 'Pembelian',
			'data' => $this->db->get('produk')->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function addProdukPembelian()
	{
		if ($this->input->is_ajax_request()) {
			$produkList = convertPostArray($this->input->post());
			$total = 0;

			foreach ($produkList as &$produk) {
				$produkId = $produk['produk'];

				$produkData = $this->db->get_where('produk', ['id' => $produkId])->row_array();

				if ($produkData) {
					$produk['nama'] = $produkData['nama'];
					$produk['kode'] = $produkData['kode'];
				} else {
					$produk['nama'] = 'Product not found';
				}
			}

			foreach ($produkList as $item) {
				$harga = intval($item["harga"]);
				$jumlah = intval($item["jumlah"]);
				$subtotal = $harga * $jumlah;
				$total += $subtotal;
			}

			echo json_encode([
				'status'  => 200,
				'message' => 'Good',
				'data'    => [
					'produk' => $produkList,
					'total' => $total
				]
			]);
		} else {
			echo json_encode([
				'status'  => 400,
				'message' => 'Bad Request!!!',
				'data'    => []
			]);
		}
	}

	public function addPembelianDB()
	{
		if ($this->input->is_ajax_request()) {
			$data = json_decode($this->input->post('datas'), true);

			$this->db->insert('pembelian', ['tanggal' =>  date("Y-m-d H:i:s")]);

			$pembelian_id = $this->db->insert_id();

			foreach ($data as $key => $row) {
				$oldData = $this->db->get_where('produk_stok', ['produk_id' => $row['produk']])->row_array();

				if ($oldData) {
					$newJumlah = $oldData['jumlah'] + $row['jumlah'];

					$this->db->update('produk_stok', ['jumlah' => $newJumlah], ['produk_id' => $row['produk']]);
					$this->db->insert('pembelian_detail', [
						'produk_id' => $row['produk'],
						'jumlah' => $row['jumlah'],
						'harga' => $row['harga'],
						'pembelian_id' => $pembelian_id,
					]);
				}
			}

			echo json_encode([
				'status'  => 200,
				'message' => 'Success insert into produk',
				'data'    => []
			]);
		} else {
			echo json_encode([
				'status'  => 400,
				'message' => 'Bad Request!!!',
				'data'    => []
			]);
		}
	}

	public function penjualan()
	{
		$data = [
			'pages' => 'usaha/penjualan',
			'title' => 'Penjualan',
			'data' => $this->db->select('COUNT(DISTINCT produk.id) as jenis_produk, SUM(penjualan_detail.harga * penjualan_detail.jumlah) as total_penjualan, SUM(penjualan_detail.jumlah) as jumlah_penjualan, penjualan.*')
				->from('penjualan_detail')
				->join('penjualan', 'penjualan_detail.penjualan_id = penjualan.id')
				->join('produk', 'penjualan_detail.produk_id = produk.id')
				->group_by('penjualan.id')
				->get()
				->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function detailPenjualan($penjualan_id)
	{
		$data = [
			'pages' => 'usaha/detailpenjualan',
			'title' => 'Detail Penjualan',
			'data' => $this->db->select('produk.nama as nama_produk, produk.kode as kode_produk, penjualan.tanggal as tanggal_penjualan, penjualan_detail.harga as harga_beli, penjualan_detail.jumlah as jumlah_penjualan')
				->from('penjualan_detail')
				->join('penjualan', 'penjualan_detail.penjualan_id = penjualan.id')
				->join('produk', 'penjualan_detail.produk_id = produk.id')
				->where('penjualan_detail.penjualan_id', $penjualan_id)
				->get()->result_array(),
			'detail' => $this->db->select('penjualan.tanggal as tanggal_penjualan, COUNT(DISTINCT produk.id) as jenis_produk, SUM(penjualan_detail.harga * penjualan_detail.jumlah) as total_penjualan, SUM(penjualan_detail.jumlah) as jumlah_penjualan, penjualan.id, penjualan.status_pembayaran')
				->from('penjualan_detail')
				->join('penjualan', 'penjualan_detail.penjualan_id = penjualan.id')
				->join('produk', 'penjualan_detail.produk_id = produk.id')
				->group_by('penjualan.id')
				->where('penjualan_detail.penjualan_id', $penjualan_id)
				->get()
				->row_array()

		];

		$this->load->view('layouts/main', $data);
	}

	public function addPenjualan()
	{
		$data = [
			'pages' => 'usaha/addpenjualan',
			'title' => 'Penjualan',
			'data' => $this->db->select('*')
				->from('produk_stok')
				->join('produk', 'produk_stok.produk_id = produk.id')
				->get()
				->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function addProdukPenjualan()
	{
		if ($this->input->is_ajax_request()) {
			$array = $this->input->post();

			$detail = [
				"pelanggan" => $array["pelanggan"],
				"pembelian" => $array["pembelian"],
				"status_pembayaran" => $array["status_pembayaran"],
				"keterangan" => $array["keterangan"]
			];

			$produk = [
				"produk" => $array["produk"],
				"jumlah" => $array["jumlah"],
				"harga" => $array["harga"]
			];

			$produkList = convertPostArray($produk);
			$total = 0;

			foreach ($produkList as &$produk) {
				$produkId = $produk['produk'];

				$produkData = $this->db->get_where('produk', ['id' => $produkId])->row_array();

				if ($produkData) {
					$produk['nama'] = $produkData['nama'];
					$produk['kode'] = $produkData['kode'];
				} else {
					$produk['nama'] = 'Product not found';
				}
			}

			foreach ($produkList as $item) {
				$harga = intval($item["harga"]);
				$jumlah = intval($item["jumlah"]);
				$subtotal = $harga * $jumlah;
				$total += $subtotal;
			}

			echo json_encode([
				'status'  => 200,
				'message' => 'Good',
				'data'    => [
					'detail' => $detail,
					'produk' => $produkList,
					'total' => $total,
				]
			]);
		} else {
			echo json_encode([
				'status'  => 400,
				'message' => 'Bad Request!!!',
				'data'    => []
			]);
		}
	}

	public function addPenjualanDB()
	{
		if ($this->input->is_ajax_request()) {
			$data = json_decode($this->input->post('datas'), true);

			$this->db->trans_start();

			$this->db->insert('penjualan', [
				'tanggal' =>  date("Y-m-d H:i:s"),
				'pelanggan' => $data['detail']['pelanggan'],
				'status_pembayaran' => $data['detail']['status_pembayaran'],
				'pembelian' => $data['detail']['pembelian'],
				'keterangan' => $data['detail']['keterangan'],
			]);

			$penjualan_id = $this->db->insert_id();

			foreach ($data['produk'] as $key => $row) {
				$rollback = false;

				$oldData = $this->db->get_where('produk_stok', ['produk_id' => $row['produk']])->row_array();

				if ($oldData) {
					$newJumlah = $oldData['jumlah'] - $row['jumlah'];

					if ($newJumlah < 0) {
						$rollback = true;
						break;
					}

					$this->db->update('produk_stok', ['jumlah' => $newJumlah], ['produk_id' => $row['produk']]);
					$this->db->insert('penjualan_detail', [
						'produk_id' => $row['produk'],
						'jumlah' => $row['jumlah'],
						'harga' => $row['harga'],
						'penjualan_id' => $penjualan_id,
					]);
				}
			}

			if ($rollback) {
				$this->db->trans_rollback();
				echo json_encode([
					'status'  => 400,
					'message' => 'Failed to insert into produk. Negative quantity encountered.',
					'data'    => []
				]);
			} else {
				$this->db->trans_complete();
				echo json_encode([
					'status'  => 200,
					'message' => 'Success insert into produk',
					'data'    => []
				]);
			}
		} else {
			echo json_encode([
				'status'  => 400,
				'message' => 'Bad Request!!!',
				'data'    => []
			]);
		}
	}


	public function getStok()
	{
		$product_id = $this->input->post('product_id');
		$result = $this->db->get_where('produk_stok', ['produk_id' => $product_id])->row_array();

		echo json_encode($result);
	}
}
