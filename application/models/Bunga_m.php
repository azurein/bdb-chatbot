<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bunga_m extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index()
	{
 
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			echo "Hello Coders!";
			header('HTTP/1.1 400 Only POST method allowed');
			exit;
		}
 
		// get request
		$body = file_get_contents('php://input');
		$this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : "-";
		$this->events = json_decode($body, true);
 
		// save log every event requests
		$this->bunga_m->log_events($this->signature, $body);
 
		// debuging data
		file_put_contents('php://stderr', 'Body: '.$body);
 
		if(is_array($this->events['events'])){
			foreach ($this->events['events'] as $event){
 
				// skip group and room event
				if(! isset($event['source']['userId'])) continue;
 
				// get user data from database
				$this->user = $this->bunga_m->getUser($event['source']['userId']);
 
				// if user not registered
				if(!$this->user) $this->followCallback($event);
				else {
					// respond event
					if($event['type'] == 'message'){
						if(method_exists($this, $event['message']['type'].'Message')){
							$this->{$event['message']['type'].'Message'}($event);
						}
					} else {
						if(method_exists($this, $event['type'].'Callback')){
							$this->{$event['type'].'Callback'}($event);
						}
					}
				}
 
			} // end of foreach
		}
	} // end of index.php

	// Debug Log
	function log_debug($body)
	{
		$this->db->set('descr', $body)
		->insert('debuglog');

		return $this->db->insert_id();
	}

	// Events Log
	function log_events($signature, $body, $transaction_code)
	{
		$this->db->set('signature', $signature)
		->set('events', $body)
		->set('transaction_code', $transaction_code)
		->set('status', 'pending')
		->insert('eventlog');

		return $this->db->insert_id();
	}

	// Event Log LINE
	function getEvent()
	{
		$this->db->select('events, question_id, transaction_code, status');
		$this->db->order_by('timestamp','DESC');
		$data = $this->db->get('eventlog')->result_array();
		return $data;
	}

	function getDetailEvent($trx){
		$data = $this->db->where('transaction_code', $trx)->get('eventlog')->row_array();
		if(count($data) > 0) return $data;
		return false;
	}

	function updateDetailEvent($trx, $status){
		$this->db->set('status', $status)
			->where('transaction_code', $trx)
			->update('eventlog');
		return $this->db->affected_rows();
	}

	// Users
	function getUser($userId)
	{
		$data = $this->db->where('user_id', $userId)->get('users')->row_array();
		if(count($data) > 0) return $data;
		return false;
	}
 
	function getAllUsers()
	{
		$data = $this->db->get('users')->result_array();
		return $data;
	}

	// Question
	function getQuestion($questionNum)
	{
		$data = $this->db->where('number', $questionNum)
			->get('questions')
			->row_array();
 
		if(count($data)>0) return $data;
		return false;
	}

	function getAllQuestion()
	{
		$data = $this->db->get('questions')->result_array();
		return $data;
	}

	function getActiveSafehouse()
	{
		$data = $this->db->where('is_active', 1)->get('safehouse')->result_array();
		if(count($data) > 0) return $data;
		return false;
	}

	function getAllSafehouse()
	{
		$data = $this->db->get('safehouse')->result_array();
		return $data;
	}

	function addUser($data){
		$this->db->insert('users', $data);
 
		return $this->db->insert_id();
	}

	function addEvent($data){
		$this->db->insert('eventlog', $data);
 
		return $this->db->insert_id();
	}

	function addSafehouse($data){
		$this->db->insert('safehouse', $data);
 
		return $this->db->insert_id();
	}

	function saveUser($profile)
	{
		$this->db->set('user_id', $profile['userId'])
			->set('display_name', $profile['displayName'])
			->insert('users');
 
		return $this->db->insert_id();
	}
 
	function setUserPhone($user_id, $newNumber)
	{
		$this->db->set('phone', $newNumber)
			->where('user_id', $user_id)
			->update('users');
 
		return $this->db->affected_rows();
	}

	function setUserProgress($user_id, $newNumber)
	{
		$this->db->set('number', $newNumber)
			->where('user_id', $user_id)
			->update('users');
 
		return $this->db->affected_rows();
	}

	function setUserTalking($user_id, $isTalking)
	{
		$this->db->set('isTalking', $isTalking)
			->where('user_id', $user_id)
			->update('users');
 
		return $this->db->affected_rows();
	}

	function setUserMode($user_id, $body)
	{
		$this->db->set('mode', $body)
			->where('user_id', $user_id)
			->update('users');
 
		return $this->db->affected_rows();
	}
	
	function resetUserTimestamp($user_id)
	{
		$this->db->set('timestamp', date('Y-m-d H:i:s'))
			->where('user_id', $user_id)
			->update('users');
 
		return $this->db->affected_rows();
	}

	function setSafehouse($data, $id)
	{
		$this->db
			->where('id', $id)
			->update('safehouse', $data);
 
		return $this->db->affected_rows();
	}

	function removeSafehouse($id)
	{
		$this->db
			->where('id', $id)
			->delete('safehouse');
	}
}
