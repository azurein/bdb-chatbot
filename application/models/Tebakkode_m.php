<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tebakkode_m extends CI_Model {

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
    $this->tebakkode_m->log_events($this->signature, $body);
 
    // debuging data
    file_put_contents('php://stderr', 'Body: '.$body);
 
    if(is_array($this->events['events'])){
      foreach ($this->events['events'] as $event){
 
        // skip group and room event
        if(! isset($event['source']['userId'])) continue;
 
        // get user data from database
        $this->user = $this->tebakkode_m->getUser($event['source']['userId']);
 
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

  // Events Log
  function log_events($signature, $body)
  {
    $this->db->set('signature', $signature)
    ->set('events', $body)
    ->insert('eventlog');

    return $this->db->insert_id();
  }

  // Users
  function getUser($userId)
  {
    $data = $this->db->where('user_id', $userId)->get('users')->row_array();
    if(count($data) > 0) return $data;
    return false;
  }
 
  function saveUser($profile)
  {
    $this->db->set('user_id', $profile['userId'])
      ->set('display_name', $profile['displayName'])
      ->insert('users');
 
    return $this->db->insert_id();
  }

  // Question
  // Question
  function getQuestion($questionNum)
  {
    $data = $this->db->where('number', $questionNum)
      ->get('questions')
      ->row_array();
 
    if(count($data)>0) return $data;
    return false;
  }
 
  function isAnswerEqual($number, $answer)
  {
    $this->db->where('number', $number)
      ->where('answer', $answer);
 
    if(count($this->db->get('questions')->row()) > 0)
      return true;
 
    return false;
  }
 
  function setUserProgress($user_id, $newNumber)
  {
    $this->db->set('number', $newNumber)
      ->where('user_id', $user_id)
      ->update('users');
 
    return $this->db->affected_rows();
  }
 
  function setScore($user_id, $score)
  {
    $this->db->set('score', $score)
      ->where('user_id', $user_id)
      ->update('users');
 
    return $this->db->affected_rows();
  }

}
