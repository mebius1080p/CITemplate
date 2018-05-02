<?php
use XXX\DB\XXXXXXXXXXXSearchConditionBuilder;
use XXX\Data\JsonObj;
use XXX\Paging\{PagingCaluculator, PagingSearchResult};

/**
 * Sample サンプルコントローラ
 */
class Sample extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("Session_manager");
		$this->load->library("Commonlib");
		$this->load->helper('url');
	}
	/**
	 * xxx 検索一覧ページを出力
	 */
	public function index()
	{
		$param = [
			"code" => session_id(),
		];
		$this->commonlib->render("xxxxxxxxxx/index.html", $param);
	}
	/**
	 * 検索を受け付ける
	 */
	public function search()
	{
		$json = new JsonObj();
		try {
			//投稿データまとめ
			$inputObj = new stdClass();
			$inputObj->xxxxxxxxxxxx = (string)$this->input->post("xxxxxxxxxxxxx");
			$inputObj->page = (int)$this->input->post("page");

			//検索条件オブジェクト作成
			$xxxscb = new XXXXXXXXXXXSearchConditionBuilder($inputObj);

			//検索(ページング考慮)
			$this->load->model("xxxxxxxxxxxxx_model");
			$searchCount = $this->xxxxxxxxxxxxx_model->search_count($xxxscb);

			$pc = new PagingCaluculator($searchCount, XXXXXXXXXXXXXX_SEARCH_PER_PAGE, $inputObj->page);
			$psr = $pc->getPagingSearchResult();
			$psr->data = $this->xxxxxxxxxxxxx_model->search($xxxscb, $pc->getOffset(), XXXXXXXXXXXXXX_SEARCH_PER_PAGE);

			$json->data = $psr;
			$json->status = "ok";
		} catch (Exception $e) {
			log_message("error", $e->getMessage());
			$json->message = "search error";
		}
		$this->commonlib->json($json);
	}
	/**
	 * xxx 情報を登録する
	 */
	public function commit()
	{
		$json = new JsonObj();
		try {
			// csrf
			$this->commonlib->checkcsrf((string)$this->input->post("code"));

			//バリデート
			$this->load->library('form_validation');
			//xxxxxxxxxxxxxxxx
			if (!$this->form_validation->run()) {
				throw new Exception("invalid commit xxxxxxxxxxx", 1);
			}

			//input まとめ
			$inputObj = new stdClass();
			$inputObj->xxxxxxxxxxxxxxx = (string)$this->input->post("xxxxxxxxxxxxxxx");

			//commit
			$this->load->model("xxxxxxxxxxxxx_model");
			$xxxxxo = $this->xxxxxxxxxxxxx_model->prepare_obj($inputObj);
			$this->xxxxxxxxxxxxx_model->commit($xxxxxo);

			$json->status = "ok";
		} catch (Exception $e) {
			log_message("error", $e->getMessage());
			$json->message = "commit error";
		}
		$this->commonlib->json($json);
	}
	/**
	 * 新規作成ページを出力
	 */
	public function add()
	{
		$param = [
			"code" => session_id(),
		];
		$this->commonlib->render("xxxxxxxxxxxx/detail.html", $param);
	}
	/**
	 * 詳細ページを出力
	 * @param string $xxxid xxx id
	 */
	public function detail($xxxid)
	{
		try {
			$intXXXid = (int)$xxxid;
			//データ取り出し
			$this->load->model("xxxxxxxxxxxxxx_model");
			$xxxo = $this->xxxxxxxxxxxxxx_model->get_by_id($intXXXid);

			$param = [
				"code" => session_id(),
				"xxx" => $xxxo
			];
			$this->commonlib->render("categxxxxxxxxxxxxory/detail.html", $param);
		} catch (Exception $e) {
			log_message("error", $e->getMessage());
			redirect("/xxxxxxxxxxxxxxx/");
		}
	}
}
