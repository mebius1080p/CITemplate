<?php
declare(strict_types=1);
use Foobar\DB\{XXXXXXXXXXSearchConditionBuilder, xxxxxxxxxxxxxxObj};
use XXX\DB\InsertHelper2;

/**
 * Sample_model sample モデル
 */
class Sample_model extends CI_Model
{
	private const TABLE_NAME = "xxxxx";
	private const SELECT_BY_ID_SQL = "SELECT * FROM %s WHERE XXXID = ?";
	private const SEARCH_COUNT_SQL = "SELECT count(0) AS cnt FROM %s %s";
	private const SEARCH_SQL = "SELECT * FROM %s %s limit ?,?";

	private const COLUMNS = [
		"xxx",
		"yyy",
	];
	public function __construct()
	{
		parent::__construct();
		// $this->load->database("xxxx");
		$this->db->conn_id->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // 静的プレースホルダを指定
		$this->db->conn_id->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //: 例外を投げる
	}
	/**
	 * xxx id からレコードを取り出すメソッド
	 * @param int $xxxid xxx id
	 * @return xxxxxxxxxxxxxxObj xxxxxxxxxxxxxxObj のインスタンス
	 * @throws Exception レコードがなければ例外
	 */
	public function get_by_id(int $xxxid): xxxxxxxxxxxxxxObj
	{
		$xxxObj = null;
		try {
			$sql = sprintf(self::SELECT_BY_ID_SQL, self::TABLE_NAME);
			$query = $this->db->query($sql, [$xxxid]);
			$result = $query->result(xxxxxxxxxxxxxxObj::class);
			if (count($result) === 0) {
				throw new Exception("record not found", 1);
			}

			$xxxObj = $result[0];
		} catch (Exception $e) {
			throw $e;
		}
		return $xxxObj;
	}
	/**
	 * 検索結果のヒット数を返すメソッド
	 * @param XXXXXXXXXXSearchConditionBuilder $xxxscb 検索条件オブジェクト
	 * @return int 検索ヒット数
	 */
	public function search_count(XXXXXXXXXXSearchConditionBuilder $xxxscb): int
	{
		$hit = 0;
		try {
			$sql = sprintf(self::SEARCH_COUNT_SQL, self::TABLE_NAME, $xxxscb->getCondition());
			$query = $this->db->query($sql, [$xxxscb->getPlaceHolder()]);
			$result = $query->result();
			$hit = $result[0]->cnt;//クエリが失敗することは想定しない
		} catch (Exception $e) {
			log_message("error", $e->getMessage());
		}
		return $hit;
	}
	/**
	 * 検索メソッド
	 * @param XXXXXXXXXXSearchConditionBuilder $xxxscb 検索条件オブジェクト
	 * @param int $offset 検索オフセット
	 * @param int $limit 一度に取得する数
	 * @param xxxxxxxxxxxxxxObj[] 条件にマッチする xxxxxxxxxxxxxxObj の配列
	 */
	public function search(XXXXXXXXXXSearchConditionBuilder $xxxscb, int $offset, int $limit): array
	{
		$result = [];
		try {
			$sql = sprintf(self::SEARCH_SQL, self::TABLE_NAME, $xxxscb->getCondition());
			$ph = $xxxscb->getPlaceHolder();
			$ph[] = $offset;
			$ph[] = $limit;

			$query = $this->db->query($sql, $ph);
			$result = $query->result(xxxxxxxxxxxxxxObj::class);
		} catch (Exception $e) {
			log_message("error", $e->getMessage());
		}
		return $result;
	}
	/**
	 * 投稿されたデータから db 格納用オブジェクトを作成して返すメソッド
	 * @param stdClass $inputObj 投稿データをまとめたオブジェクト
	 * @return xxxxxxxxxxxxxxObj xxxxxxxxxxxxxxObj のインスタンス
	 * @throws Exception 更新時、レコードがなければ例外
	 */
	public function prepare_obj(stdClass $inputObj): xxxxxxxxxxxxxxObj
	{
		$xxxObj = null;
		if ($inputObj->xxxid === 0) {// 新規
			$xxxObj = new xxxxxxxxxxxxxxObj();
			//inputObj からデータ設定
			//xxxxxxxxxxxxx
		} else {
			$xxxObj = $this->get_by_id($inputObj->xxxid);//なければ例外
			//inputObj からデータ更新
			//xxxxxxxxxxxxx
		}
		//新規・更新ともに設定
		$xxxObj->xxx = $inputObj->xxx;
		return $xxxObj;
	}
	/**
	 * データ登録するメソッド
	 * @param xxxxxxxxxxxxxxObj $xxxObj 登録するデータを保持したオブジェクト
	 * @throws Exception データ登録失敗で例外
	 */
	public function commit(xxxxxxxxxxxxxxObj $xxxObj): void
	{
		try {
			$this->db->trans_begin();
			$ih = new InsertHelper2(self::TABLE_NAME, self::COLUMNS);
			$sql = $ih->getOnDuplicateSQL();
			$query = $this->db->query($sql, [
				$xxxObj->xxxxxxxxx,
			]);
			$this->db->trans_commit();
		} catch (Exception $e) {
			$this->db->trans_rollback();
			throw $e;
		}
	}
}
