<?php
/**
 * Session manager
 */
class Session_manager
{
	private $CI;
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
	}
	/**
	 * ログインしているかチェックする
	 * @return bool 認証してログインしたかどうかを返す
	 */
	public function is_loggedin(): bool
	{
		return isset($this->CI->session->logon);
	}
	/**
	 * DB からのユーザーレコードなどを引数に、それをセッションに保存する
	 * ログインしたらとりあえずこれを呼ぶ
	 * @param mixed $userObj ユーザーに関するデータ
	 */
	public function set_user_obj($userObj): void
	{
		$this->CI->session->logon = "ok";
		$this->CI->session->user_obj = json_encode($userObj, JSON_UNESCAPED_UNICODE);
	}
	/**
	 * セッションに保存したユーザーのデータを取り出す
	 * @return stdClass json デコードしたユーザーのデータ
	 */
	public function get_user_obj(): stdClass
	{
		return json_decode($this->CI->session->user_obj);
	}
	/**
	 * ログアウト用のセッション破壊メソッド
	 * あまり必要ないかも
	 */
	public function destroy_session(): void
	{
		$this->CI->session->sess_destroy();
	}
}
