<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $active = '';

	public function __construct()
	{
		parent::__construct();
	}

	public function view($page, $data = [])
	{
		$data['is_login'] = !empty($this->ion_auth->get_user_id());
		$data['active'] = $this->active;
		$this->load->view('template/header', $data);
		$this->load->view($page);
		$this->load->view('template/footer');
	}

	public function view_guest($page, $data = [])
	{
		$this->load->view('template/header_guest', $data);
		$this->load->view($page);
		$this->load->view('template/footer_guest');
	}
}

/* End of file MY_Controller.php */
