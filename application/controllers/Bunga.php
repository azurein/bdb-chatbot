<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bunga extends CI_Controller {

	private $bot;
	private $events;
	private $signature;
	private $user;

	function __construct()
	{
		parent::__construct();
		$this->load->model('bunga_m');
	}

	function index()
	{
		echo "masuk";
	}

	public function getFeedLINE()
	{
		$finalFeeds = [];
		$arrFeeds = [];
		$questionId = [];
		$transactionCode = [];
		$status = [];
		$feeds = $this->bunga_m->getEvent();

		foreach ($feeds as $key1 => $feed) {
			array_push($arrFeeds, json_decode($feed['events'], true));
			array_push($questionId, $feed['question_id']);
			array_push($transactionCode, $feed['transaction_code']);
			array_push($status, $feed['status']);
		}

		$userId = [];
		foreach ($arrFeeds as $key => $arrFeed) {
			array_push($userId, $arrFeed['events'][0]['source']['userId']);
		}

		$submitDate = [];
		foreach ($arrFeeds as $key => $arrFeed) {
			if (strlen($arrFeed['events'][0]['timestamp']) > 10) {
				array_push($submitDate, date('d F Y', floor($arrFeed['events'][0]['timestamp']/1000)));
			} else {
				array_push($submitDate, date('d F Y', $arrFeed['events'][0]['timestamp']));
			}
		}

		$submitTime = [];
		foreach ($arrFeeds as $key => $arrFeed) {
			if (strlen($arrFeed['events'][0]['timestamp']) > 10) {
				array_push($submitTime, date('H:i', floor($arrFeed['events'][0]['timestamp']/1000)));
			} else {
				array_push($submitTime, date('H:i', $arrFeed['events'][0]['timestamp']));
			}
		}

		$message = [];
		foreach ($arrFeeds as $key => $arrFeed) {
			array_push($message, $arrFeed['events'][0]['message']);
		}

		for ($i=0; $i < count($arrFeeds); $i++) {
			$temp = array(
				'userId' => $userId[$i], 
				'displayName' => '', 
				'phone' => '',
				'submitDate' => isset($submitDate[$i]) ? $submitDate[$i] : '',  
				'submitTime' => isset($submitTime[$i]) ? $submitTime[$i] : '', 
				'message' => isset($message[$i]) ? $message[$i] : '',
				'questionId' => isset($questionId[$i]) ? $questionId[$i] : '',
				'question' => '',
				'transactionCode' => isset($transactionCode[$i]) ? $transactionCode[$i] : '',
				'status' => isset($status[$i]) ? $status[$i] : '',
			);
			array_push($finalFeeds, $temp);
		}

		$arrUsers = $this->bunga_m->getAllUsers();
		$arrQuestions = $this->bunga_m->getAllQuestion();
		foreach ($finalFeeds as $key => &$finalFeed) {
			foreach ($arrUsers as $keyUser => $arrUser) {
				if ($finalFeed['userId'] == $arrUser['user_id']) {
					$finalFeed['displayName'] = $arrUser['display_name'];
					$finalFeed['phone'] = $arrUser['phone'];
				}
			}
			foreach ($arrQuestions as $keyQuestion => $arrQuestion) {
				if ($finalFeed['questionId'] == $arrQuestion['id']) {
					$finalFeed['question'] = $arrQuestion['text'];
				}
			}
		}

		echo json_encode($finalFeeds);
	}

	public function openModalEvent($trx_id){
		$trx_id = (string)urldecode($trx_id);
		$this->data['content_event'] = $this->bunga_m->getDetailEvent($trx_id);
		$this->load->view('backend/newsfeed_modal',$this->data);
	}

	public function updateEvent($trx_id){
		$trx_id = (string)urldecode($trx_id);
		if($_POST){
			$this->bunga_m->updateDetailEvent($trx_id, $this->input->post('status'));
			redirect('backend/newsfeed');
		}
	}
}