<?php
use Foobar\DB\UserObj;
/**
 * User_model user テーブルに関するモデルクラス
 */
class User_model extends CI_Model
{
	const TABLE_NAME = "user";
	const SELECT_BY_LOGINID_SQL = "SELECT * FROM %s WHERE user_login = ?";
	public function __construct()
	{
		parent::__construct();
		$this->load->database("foobar");
		$this->db->conn_id->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // 静的プレースホルダを指定
		$this->db->conn_id->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 例外を投げる
	}
	/**
	 * ログイン id からレコードの取得を試みるメソッド
	 * @param string $loginid ユーザーの post したログインid
	 * @return UserObj ユーザーレコード 1 件分
	 * @throws Exception db エラーもしくはレコードがない場合に例外
	 */
	public function get_by_loginid($loginid)
	{
		$sql = sprintf(self::SELECT_BY_LOGINID_SQL, self::TABLE_NAME);
		$query = $this->db->query($sql, [$loginid]);
		$result = $query->result(UserObj::class);
		if (count($result) === 0) {
			throw new Exception("user record not found", 1);
		}
		return $result[0];
	}
}
