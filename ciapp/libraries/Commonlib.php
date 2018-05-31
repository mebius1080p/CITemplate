<?php
declare(strict_types=1);
use Mebius\Net\CSPManager;

/**
 * Commonlib CI で共通して使う共通クラス
 */
class Commonlib
{
	public function __construct()
	{
		// d;
	}
	/**
	 * csrf チェック
	 * @param string $code 送られてきた csrf チェック用コード
	 * @throws Exception コードが一致しない場合に例外
	 */
	public function checkcsrf(string $code): void
	{
		if (!(session_id() === $code)) {
			throw new Exception("invalid access detected", 1);
		}
	}
	/**
	 * Twig で html 出力するメソッド
	 * @param string $fileName 出力する html のファイルパス(相対)
	 * @param array $param テンプレートエンジンに渡すパラメーター
	 * @param CSPManager $csp CSPManager のインスタンス
	 */
	public function render(string $fileName, array $param, CSPManager $csp = null): void
	{
		$loader = new Twig_Loader_Filesystem(VIEWPATH . "/templates");
		$twig = new Twig_Environment($loader);
		// apache の vhost などでヘッダー出力する場合は不要
		header("X-Frame-Options:  SAMEORIGIN");
		header("X-XSS-Protection: 1; mode=block");
		header("X-Content-Type-Options: nosniff");
		header("content-type: text/html; charset=utf-8");

		if ($csp === null) {
			$csp = new CSPManager();
		}
		header($cspHeader = $csp->getCSP());

		echo $twig->render($fileName, $param);
	}
	/**
	 * json を出力するメソッド
	 * @param mixed $obj 配列や stdClass など
	 */
	public function json($obj): void
	{
		header("Content-Type: application/json; charset=utf-8");
		echo json_encode($obj, JSON_UNESCAPED_UNICODE);
	}
	/**
	 * デバッグ用メソッド
	 * @param mixed $obj 何でも
	 */
	public function debug($obj): void
	{
		if (!defined("DEBUG_FILE") || empty(DEBUG_FILE)) {
			return;
		}
		$dt = new DateTime();
		$now = $dt->format("Y-m-d H:i:s");
		$debugStr = $now . ":" . print_r($obj, true) . "\n";
		file_put_contents(DEBUG_FILE, $debugStr, LOCK_EX | FILE_APPEND);
	}
}
