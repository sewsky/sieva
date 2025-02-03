<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends MY_Controller
{
	public function index()
	{
		$this->view('contact/contact');
	}
}

/* End of file Contact.php */
