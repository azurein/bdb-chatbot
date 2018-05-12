<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	public function __construct(){
		$this->need_auth = false;
		parent::__construct();
	}
    public function index(){
		$this->data['fail'] = false;
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->data['fail'] = true;
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			redirect('index.php/backend/newsfeed');
		}
		$this->load->view('backend/login',$this->data);
	}
}