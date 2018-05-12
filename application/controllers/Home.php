<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('bunga_m');
	}

	public function index()
	{
		$this->data['questions'] = $this->bunga_m->getAllQuestion();
		if($_POST) {
			$dataUser['user_id'] = $this->input->post('email');
			$dataUser['display_name'] = $this->input->post('name');
			$dataUser['phone'] = $this->input->post('hp');
			$dataUser['number'] = 0;

			if(!$this->bunga_m->getUser($dataUser['user_id'])){
				$this->bunga_m->addUser($dataUser);
			}
			
			$date = date('dmY');
			$time = date('His');
			$transaction_code = $dataUser['user_id'].'_'.$date.'_'.$time;
			$textarea = json_encode(htmlentities($this->input->post('textarea')));
			$dataEvents['signature'] = "form";
			$dataEvents['transaction_code'] = $transaction_code;
			$dataEvents['status'] = "pending";
			$dataEvents['question_id'] = 0;
			$dataEvents['events'] = '{"events":[{"type":"message","replyToken":"0","source":{"userId":"'.$dataUser['user_id'].'","type":"user"},"timestamp":'.time().',"message":{"type":"form","id":"'.$transaction_code.'_message","text":'.$textarea.'}}]}';

			$this->bunga_m->addEvent($dataEvents);

			foreach($this->data['questions'] as $key => $question){
				$dataEvents['question_id'] = $question['id'];
				$dataEvents['events'] ='{"events":[{"type":"message","replyToken":"0","source":{"userId":"'.$dataUser['user_id'].'","type":"user"},"timestamp": '.time().',"message": {"type": "form","id":"'.$transaction_code.'_question_'.$question['id'].'","text": "'.$this->input->post('question_'.$question['id']).'"}}]}';

				$this->bunga_m->addEvent($dataEvents);
			}
			redirect('home/thankyou');
		}
		else {
			$this->load->view('home',$this->data);
		}
	}
	public function thankyou()
	{
		$this->load->view('thankyou');
	}
}
