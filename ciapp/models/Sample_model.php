<?php
declare(strict_types=1);
use Foobar\DB\{XXXXXXXXXXSearchConditionBuilder, xxxxxxxxxxxxxxObj};

/**
 * Sample_model sample モデル
 */
class Sample_model extends CI_Model
{
	private const TABLE_NAME = "xxxxx";
	private const SEARCH_COUNT_SQL = "SELECT count(0) AS cnt FROM %s %s";
	private const SEARCH_SQL = "SELECT * FROM %s %s limit ?,?";
	public function __construct()
	{
		parent::__construct();
		// $this->load->database("xxxx");
		$this->db->conn_id->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // 静的プレースホルダを指定
		$this->db->conn_id->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //: 例外を投げる
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
			$query = $this->db->query($sql, [$cscb->getPlaceHolder()]);
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
}
