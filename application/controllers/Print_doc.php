<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Print_doc extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Sertifikat_model');
		$this->load->library('ion_auth');
		if (empty($this->ion_auth->get_user_id())) {
			show_404();
			exit();
		}
	}

	public function index()
	{
		$this->active = 'printer';
		$this->view('print/print');
	}

	public function docprint()
	{
		$checklist = $this->input->post('checklist');
		if (count($checklist) == 0) {
			show_404();
			exit();
		}
		$res = $this->Sertifikat_model->get_by_id_in($checklist);
		foreach ($res as $row) :
			$this->view_guest('print/docprint', [
				'data_sertifikat' => $row,
			]);
		endforeach;
		echo "
		<script>
			window.print();
			setTimeout(function() {
				window.close();
			}, 2000);
		</script>";
	}
}

/* End of file About.php */
