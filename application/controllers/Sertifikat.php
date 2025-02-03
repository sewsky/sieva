<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sertifikat extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Sertifikat_model');
		$this->load->library('ion_auth');
	}

	public function json()
	{
		if (empty($this->ion_auth->get_user_id())) {
			show_404();
			exit();
		}
		header('Content-Type: application/json');
		echo $this->Sertifikat_model->json($this->ion_auth->get_user_id());
	}

	public function export_data()
	{
		if (empty($this->ion_auth->get_user_id())) {
			show_404();
			exit();
		}
		$this->Sertifikat_model->export_data($this->ion_auth->get_user_id());
	}

	public function export_template()
	{
		if (empty($this->ion_auth->get_user_id())) {
			show_404();
			exit();
		}
		$this->Sertifikat_model->export_template();
	}

	public function upload_file()
	{
		if (empty($this->ion_auth->get_user_id())) {
			return [
				'status' => false,
				'msg' => 'Unauthorized',
			];
		}
		if (empty($_FILES['file']['name'])) {
			return [
				'status' => false,
				'msg' => 'File tidak ditemukan',
			];
		}
		$config['upload_path'] = 'assets/excels/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('file')) {
			$data = $this->upload->data();
			return [
				'status' => true,
				'msg' => 'success',
				'data' => $data,
			];
		} else {
			return [
				'status' => false,
				'msg' => $this->upload->display_errors(),
			];
		}
	}

	public function import_template()
	{
		$upload = $this->upload_file();
		if (!$upload) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(405)
				->set_output(json_encode($upload));
		}
		$r = $this->Sertifikat_model->import_template($upload['data']);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(201)
			->set_output(json_encode([
				'msg' => count($r) . ' data berhasil di tambahkan',
			]));
	}

	public function update_bulk()
	{
		if (empty($this->ion_auth->get_user_id())) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(401)
				->set_output(json_encode([
					'msg' => 'Unauthorized',
				]));
		}
		if (empty($this->input->post('cell_update')) || count($this->input->post('cell_update')) == 0) {
			$this->form_validation->set_rules('cell_update', 'Data update', 'required|trim');
			return $this->output
				->set_content_type('application/json')
				->set_status_header(405)
				->set_output(json_encode([
					'msg' => 'Tidak ada data yang di update!',
				]));
		}
		$i = 0;
		$cell_update = $this->input->post('cell_update');
		foreach ($cell_update as $row) :
			$row = (object) $row;
			$allow_update = true;
			if ($row->key == 'kode_sertifikat') { // unique
				$this->db->where($row->key, $row->value);
				$this->db->where('id!=', $row->id);
				$rcek = $this->db->get('sertifikat')->row();
				if ($rcek) {
					$allow_update = false;
				}
			}
			if ($allow_update) {
				$this->Sertifikat_model->update($row->id, [
					$row->key => $row->value,
				]);
				$i++;
			}
		endforeach;
		return $this->output
			->set_content_type('application/json')
			->set_status_header(201)
			->set_output(json_encode([
				'msg' => $i . ' Sel berhasil di edit!',
			]));
	}

	public function delete_bulk()
	{
		if (empty($this->ion_auth->get_user_id())) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(401)
				->set_output(json_encode([
					'msg' => 'Unauthorized',
				]));
		}
		if (empty($this->input->post('rows_delete')) || count($this->input->post('rows_delete')) == 0) {
			$this->form_validation->set_rules('rows_delete', 'Data', 'required|trim');
			return $this->output
				->set_content_type('application/json')
				->set_status_header(405)
				->set_output(json_encode([
					'msg' => 'Tidak ada data yang akan di hapus!',
				]));
		}
		$i = 0;
		$rows_delete = $this->input->post('rows_delete');
		foreach ($rows_delete as $row) :
			$row = (object) $row;
			$this->Sertifikat_model->delete($row->value);
			$i++;
		endforeach;
		return $this->output
			->set_content_type('application/json')
			->set_status_header(201)
			->set_output(json_encode([
				'msg' => $i . ' data berhasil di hapus!',
			]));
	}
}

/* End of file Sertifikat.php */
