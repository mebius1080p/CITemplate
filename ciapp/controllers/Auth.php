<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 認証コントローラ
 */
class Auth extends CI_Controller
{
	const AFTER_LOGIN = "../../../app/foobar/";
	const LOGIN_REDIRECT = "../../../app/";
	public function __construct()
	{
		parent::__construct();
		$this->load->library("Session_manager");
		$this->load->library("Commonlib");
		$this->load->helper('url');
	}
	public function index()
	{
		$param = [
			"code" => session_id(),
		];
		$this->commonlib->render("login.html", $param);
	}
	public function login()
	{
		try {
			//csrf チェック
			$this->commonlib->checkcsrf((string)$this->input->post("code"));

			//バリデーター
			$this->load->library('form_validation');
			$this->form_validation->set_rules('loginid', '', 'required');
			$this->form_validation->set_rules('password', '', 'required');
			if (!$this->form_validation->run()) {
				throw new Exception("invalid login info", 1);
			}

			//投稿情報まとめ
			$inputObj = new stdClass();
			$inputObj->user = $this->input->post("loginid");
			$inputObj->pass = $this->input->post("password");

			//データ引っ張り
			$this->load->model("user_model");
			$userRecord = $this->user_model->get_by_loginid($inputObj->user);//中で例外を出せる

			//パスワード照合
			$isValidUser = password_verify($inputObj->pass, $userRecord->user_pass);
			if (!$isValidUser) {
				throw new Exception("invalid password", 1);
			}

			//パスワードは消去
			$userRecord->user_pass = "";
			//セッションに保存
			$this->session_manager->set_user_obj($userRecord);

			//リダイレクト前にセッション更新
			session_regenerate_id(true);
			redirect(self::AFTER_LOGIN);
		} catch (Exception $e) {
			log_message("error", $e->getMessage());
			redirect(self::LOGIN_REDIRECT);
		}
	}
	public function logout()
	{
		session_destroy();
		redirect(self::LOGIN_REDIRECT);
	}
}
