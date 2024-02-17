<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan extends CI_Controller
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
		$firstDayOfMonth = date('Y-m-01');
		$lastDayOfMonth = date('Y-m-t');

		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		$data = [
			'pages' => 'aruskas',
			'title' => 'Arus Kas',
			'data' => $this->db->select('*')
				->from('arus_kas')
				->where("tanggal BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'")
				->where('user_id', $user['id'])
				->order_by('id', 'desc')
				->get()
				->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function dashboard()
	{
		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		$result = $this->db->select('kategori, SUM(jumlah) as total')
			->from('arus_kas')
			->group_by('kategori')
			->where('DATE(tanggal) >=', date('Y-m-01'))
			->where('DATE(tanggal) <=', date('Y-m-t'))
			->get()
			->result_array();

		$formattedResult = [];
		foreach ($result as $row) {
			$formattedResult[$row['kategori']] = $row;
		}

		$data = [
			'pages' => 'dashboard',
			'title' => 'Dashboard',
			'data' => [
				'saldo' => $this->db->get_where('saldo', ['user_id' => $user['id']])->row_array(),
				'arus_kas' => $formattedResult,
			]
		];

		$this->load->view('layouts/main', $data);
	}

	public function perbulan()
	{
		$desiredMonth = date("Y-m");

		$firstDayOfMonth = $desiredMonth . '-01';
		$lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

		$result = $this->db->select('kategori, SUM(jumlah) as total')
			->from('arus_kas')
			->group_by('kategori')
			->where("tanggal BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'")
			->get()
			->result_array();

		$formattedResult = [];
		foreach ($result as $row) {
			$formattedResult[$row['kategori']] = $row;
		}

		$data = [
			'pages' => 'aruskasperbulan',
			'title' => 'Arus Kas Perbulan',
			'data' => $this->db->select('*')
				->from('arus_kas')
				->where("tanggal BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'")
				->order_by('id', 'desc')
				->get()->result_array(),
			'kas' => $formattedResult
		];

		$this->load->view('layouts/main', $data);
	}

	public function perbulaan()
	{
		$desiredMonth = $this->input->post('tahunBulan');

		$firstDayOfMonth = $desiredMonth . '-01';
		$lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

		$result = $this->db->select('kategori, SUM(jumlah) as total')
			->from('arus_kas')
			->group_by('kategori')
			->where("tanggal BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'")
			->get()
			->result_array();

		$formattedResult = [];
		foreach ($result as $row) {
			$formattedResult[$row['kategori']] = $row;
		}

		$data = [
			'pages' => 'aruskasperbulan',
			'title' => 'Arus Kas Perbulan',
			'data' => $this->db->select('*')
				->from('arus_kas')
				->where("tanggal BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'")
				->order_by('id', 'desc')
				->get()->result_array(),
			'kas' => $formattedResult
		];

		$this->load->view('layouts/main', $data);
	}



	public function kebutuhan()
	{
		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		$data = [
			'pages' => 'kebutuhan',
			'title' => 'Kebutuhan',
			'data' => $this->db->get_where('kebutuhan', ['user_id' => $user['id']])->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function tabungan()
	{
		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		$data = [
			'pages' => 'tabungan',
			'title' => 'Tabungan',
			'data' => $this->db->select('*')
				->from('tabungan')
				->where('user_id', $user['id'])
				->order_by('id', 'desc')
				->get()->result_array()
		];

		$this->load->view('layouts/main', $data);
	}

	public function addKas()
	{
		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required|trim');
		$this->form_validation->set_rules('pembayaran', 'Pembayaran', 'required|trim');
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');

		if ($this->form_validation->run() == false) {
			redirect('keuangan');
		} else {
			if ($this->input->is_ajax_request()) {
				$data = $this->input->post();

				$saldo_kas = 0;
				$saldo_tabungan = 0;

				$saldo = $this->db->select('*')
					->from('saldo')
					->where('user_id', $user['id'])
					->get()
					->row_array();

				if ($saldo === null) {
					$saldo_kas = toNumber($data['jumlah']);
				} elseif ($data['kategori'] === 'in') {
					$saldo_kas = $saldo['saldo_kas'] + toNumber($data['jumlah']);
				} elseif ($data['kategori'] === 'out' || $data['kategori'] === 'need') {
					$saldo_kas = $saldo['saldo_kas'] - toNumber($data['jumlah']);
				} elseif ($data['kategori'] === 'save') {
					$saldo_kas = $saldo['saldo_kas'] - toNumber($data['jumlah']);
					$saldo_tabungan = $saldo['saldo_tabungan'] + toNumber($data['jumlah']);
				}

				$this->db->insert('arus_kas', [
					'tanggal' => date('Y-m-d'),
					'keterangan' => $data['keterangan'],
					'kategori' => $data['kategori'],
					'dompet' => strtolower($data['pembayaran']),
					'jumlah' => toNumber($data['jumlah']),
					'user_id' => $user['id']
				]);

				if ($data['kategori'] === 'save') {
					$this->db->insert('tabungan', [
						'tanggal' => date('Y-m-d'),
						'kategori' => $data['kategori'] === 'save' ? 'in' : '',
						'keterangan' => $data['keterangan'],
						'jumlah' => toNumber($data['jumlah']),
						'user_id' => $user['id'],
						'kas_id' => $this->db->insert_id()
					]);
				}

				$this->db->update('saldo', [
					'saldo_kas' => $saldo_kas,
					'saldo_tabungan' => $saldo_tabungan,
				], ['user_id' => $user['id']]);


				echo json_encode([
					'status'  => 200,
					'message' => 'Success insert into arus kas',
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
	}

	public function addKebutuhan()
	{
		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();

			$this->db->insert('kebutuhan', [
				'nama' => $data['kebutuhan'],
				'harga' => toNumber($data['harga']),
				'user_id' => $user['id'],
			]);

			echo json_encode([
				'status'  => 200,
				'message' => 'Success insert into kebutuhan',
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

	public function deleteKebutuhan()
	{
		if ($this->input->is_ajax_request()) {

			$data = $this->input->post();

			$this->db->delete('kebutuhan', ['id' => $data['id']]);

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

	public function deleteKas()
	{
		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		if ($this->input->is_ajax_request()) {
			$data = $this->input->post();

			$kas = $this->db->get_where('arus_kas', ['id' => $data['id']])->row_array();

			if ($kas['kategori'] === 'save') {
				$this->db->delete('tabungan', ['kas_id' => $kas['id']]);

				$this->db->set('saldo_kas', 'saldo_kas + ' . $kas['jumlah'], FALSE)
					->set('saldo_tabungan', 'saldo_tabungan - ' . $kas['jumlah'], FALSE)
					->where('id', $user['id'])
					->update('saldo');
			}

			$this->db->delete('arus_kas', ['id' => $data['id']]);

			echo json_encode([
				'status'  => 200,
				'message' => 'Success deleted kas',
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

	public function getKebutuhan()
	{
		$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();

		$kategori = $this->input->post('kategori');

		if ($kategori === "need") {
			$data = $this->db->select_sum('harga', 'total_harga')->get_where('kebutuhan', ['user_id'  => $user['id']])->row()->total_harga;
			echo json_encode($data);
		} else {
			echo json_encode([]);
		}
	}

	public function ambilTabungan()
	{
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');
		$this->form_validation->set_rules('jumlah', 'Jumlah', 'required|trim');

		if ($this->form_validation->run() == false) {
			redirect('keuangan/tabungan');
		} else {
			$user = $this->db->get_where('users', ['username' => $this->session->userdata('username')])->row_array();
			$saldo =  $this->db->get_where('saldo', ['user_id' => $user['id']])->row_array();

			if ($this->input->is_ajax_request()) {
				$data = $this->input->post();

				$this->db->update('saldo', ['saldo_tabungan' => $saldo['saldo_tabungan'] - toNumber($data['jumlah'])], ['user_id' => $user['id']]);

				$this->db->insert('arus_kas', [
					'tanggal' => date('Y-m-d'),
					'keterangan' => "Ambil Tabungan (" . $data['keterangan'] . ")",
					'kategori' => "out",
					'dompet' => '-',
					'jumlah' => toNumber($data['jumlah']),
					'user_id' => $user['id']
				]);

				$this->db->insert('tabungan', [
					'tanggal' => date('Y-m-d'),
					'keterangan' => "Ambil Tabungan (" . $data['keterangan'] . ")",
					'kategori' => "out",
					'jumlah' => toNumber($data['jumlah']),
					'user_id' => $user['id'],
					'kas_id' => $this->db->insert_id()
				]);

				echo json_encode([
					'status'  => 200,
					'message' => 'Success update kas',
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
	}
}
