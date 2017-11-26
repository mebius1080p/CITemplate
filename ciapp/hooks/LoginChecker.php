<?php

/**
 * LoginChecker CI 用ログインチェッククラス。フックに登録して使用する
 */
class LoginChecker
{
	/**
	 * @var array ログインチェックしない url
	 */
	const IGNORE_URLS = [
		"",//空文字必須
		"app",
		"app/login",
		"app/logout",
	];
	private $CI;
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library("Session_manager");
	}
	public function check()
	{
		$accessURL =  $this->CI->uri->uri_string;
		if (in_array($accessURL, self::IGNORE_URLS)) {
			return;
		}

		if (!$this->CI->session_manager->is_loggedin()) {
			redirect("../../../app/");
		}
	}
}
