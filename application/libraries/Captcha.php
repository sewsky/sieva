<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Captcha
{
	protected $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
	}

	function match($pass)
	{
		$CAPTCHA_CODE = $this->ci->session->userdata('CAPTCHA_CODE');
		if (empty($CAPTCHA_CODE)) {
			return false;
		}
		if ($CAPTCHA_CODE != $pass) {
			return false;
		}
		return true;
	}

	function gen_img()
	{
		$random_num = md5(random_bytes(64));
		$captcha_code = substr($random_num, 0, 4);
		$array = array(
			'CAPTCHA_CODE' => $captcha_code,
		);
		$this->ci->session->set_userdata($array);
		$layer = imagecreatetruecolor(168, 37);
		$captcha_bg = imagecolorallocate($layer, 247, 174, 71);
		imagefill($layer, 0, 0, $captcha_bg);
		$captcha_text_color = imagecolorallocate($layer, 0, 0, 0);
		imagestring($layer, 5, 55, 10, $captcha_code, $captcha_text_color);
		header("Content-type: image/jpeg");
		imagejpeg($layer);
	}
}

/* End of file Captcha.php */
