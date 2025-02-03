<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sertifikat_model');
		$this->load->library('captcha');
	}

	public function index()
	{
		if ($this->ion_auth->get_user_id()) {
			$this->active = 'upload-template';
			$this->view('dashboard/dashboard');
		} else {
			if (!empty($this->session->userdata('nomor_sertifikat'))) {
				$nomor_sertifikat = $this->session->userdata('nomor_sertifikat');
				$r = $this->Sertifikat_model->get_by_nomor_sertifikat($nomor_sertifikat);
				$this->view_guest('dashboard/dashboard_guest', [
					'data_sertifikat' => $r,
				]);
			} else {
				$this->cek();
			}
		}
	}

	public function img_captcha()
	{
		$this->captcha->gen_img();
	}

	public function cek()
	{
		if ($this->ion_auth->get_user_id()) {
			show_404();
		}

		$this->form_validation->set_rules('nomor_sertifikat', 'Nomor Sertifikat', 'required|trim');
		$this->form_validation->set_rules('captcha_code', 'Captcha', 'required|trim');

		if ($this->form_validation->run() == true) {
			if ($this->captcha->match($this->input->post('captcha_code')) == true) {
				$nomor_sertifikat = $this->input->post('nomor_sertifikat');
				$array = array(
					'nomor_sertifikat' => $nomor_sertifikat
				);
				$this->session->set_userdata($array);
				redirect(site_url());
			} else {
				$this->data['message'] = '<p>CAPTCHA Salah!</p>';
				$this->load->view('cek/cek', $this->data);
			}
		} else {
			$this->session->unset_userdata('nomor_sertifikat');
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->view('cek/cek', $this->data);
		}
	}
}

/* End of file Dashboard.php */
