<?php defined('BASEPATH') OR exit('No direct script access allowed');

use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use \LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use \LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use \LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;

class WebhookBunga extends CI_Controller {

	private $bot;
	private $events;
	private $signature;
	private $user;
	private $bantuan;

	function __construct()
	{
		parent::__construct();
		$this->load->model('bunga_m');

		// create bot object
		$httpClient = new CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
		$this->bot  = new LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);
	}

	public function index()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			echo "Hello Sister!";
			header('HTTP/1.1 400 Only POST method allowed');
			exit;
		}

		// get request
		$body = file_get_contents('php://input');
		$this->signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : "-";
		$this->events = json_decode($body, true);

		if (is_array($this->events['events'])) {

			foreach ($this->events['events'] as $event){
 
				// skip group and room event
				if (!isset($event['source']['userId'])) continue;
 
				// get user data from database
				$this->user = $this->bunga_m->getUser($event['source']['userId']);
 
				// log every event requests
				$transaction_code = $this->user['user_id'].'_'.$this->user['timestamp'];
				$this->bunga_m->log_events($this->signature, $body, $transaction_code);

				// if user not registered
				if (!$this->user) $this->followCallback($event);
				else {
					// respond event
					if ($event['type'] == 'message'){
						if (method_exists($this, $event['message']['type'].'Message')){
							$this->{$event['message']['type'].'Message'}($event);
						}
					} else {
						if (method_exists($this, $event['type'].'Callback')){
							$this->{$event['type'].'Callback'}($event);
						}
					}
				}
 
			} // end of foreach
		}
	} // end of index.php

	private function followCallback($event)
	{
		$res = $this->bot->getProfile($event['source']['userId']);
		if ($res->isSucceeded()) {
			$profile = $res->getJSONDecodedBody();
 
			// create welcome message
			$message  = "Halo, " . $profile['displayName'] . "!\n";
			$message .= "Dalam keadaan darurat, katakan \"TOLONG\" / \"HELP\".\n";
			$message .= "Untuk mencari tempat perlindungan, katakan \"LAPOR\" / \"CURHAT\".\n";
			$message .= "Apabila kekerasan telah terjadi pada dirimu, katakan \"PERLINDUNGAN\" / \"SAFEHOUSE\".\n\n";
			$message .= "Namun pertama-tama, daftarkan dulu nomor Handphone-mu.";
			$textMessageBuilder = new TextMessageBuilder($message);
 
			// merge all message
			$multiMessageBuilder = new MultiMessageBuilder();
			$multiMessageBuilder->add($textMessageBuilder);
 
			// send reply message
			$this->bot->replyMessage($event['replyToken'], $multiMessageBuilder);
 
			// save user data
			$this->bunga_m->saveUser($profile);
		}
	}

	private function textMessage($event)
	{
		$userMessage = $event['message']['text'];
		if ($this->user['phone'] == '') {
			$this->bunga_m->setUserPhone($this->user['user_id'], $userMessage);

			$message = "Nomor Handphone-mu berhasil disimpan.";
			$textMessageBuilder = new TextMessageBuilder($message);
			$this->bot->replyMessage($event['replyToken'], $textMessageBuilder);
		} else {
			if ($this->user['number'] == 0) {
				if (strpos(strtolower($userMessage), 'tolong') !== FALSE || strpos(strtolower($userMessage), 'help') !== FALSE) {
					// update user state
					$this->bunga_m->setUserProgress($this->user['user_id'], 1);
					$this->bunga_m->setUserMode($this->user['user_id'], 'help');
	
					// asking location
					$message = "Segera kirimkan lokasi Anda, we got your back!";
					$textMessageBuilder = new TextMessageBuilder($message);
					$this->bot->replyMessage($event['replyToken'], $textMessageBuilder);
	
				} else if (strpos(strtolower($userMessage), 'lapor') !== FALSE || strpos(strtolower($userMessage), 'curhat') !== FALSE) {
					// update number progress
					$this->bunga_m->setUserProgress($this->user['user_id'], 1);
					$this->bunga_m->setUserMode($this->user['user_id'], 'report');
	
					// send question no.1
					$this->sendQuestion($event['replyToken'], 1);
	
				}  else if (strpos(strtolower($userMessage), 'perlindungan') !== FALSE || strpos(strtolower($userMessage), 'safehouse') !== FALSE) {
					// update number progress
					$this->bunga_m->setUserProgress($this->user['user_id'], 1);
					$this->bunga_m->setUserMode($this->user['user_id'], 'safehouse');
	
					// asking location
					$message = "Segera kirimkan lokasi Anda untuk mengetahui CP Rumah Aman terdekat";
					$textMessageBuilder = new TextMessageBuilder($message);
					$this->bot->replyMessage($event['replyToken'], $textMessageBuilder);
					
				} else {
					// re-create welcome message
					$message = "Dalam keadaan darurat, katakan \"TOLONG\" / \"HELP\".\n";
					$message .= "Untuk mencari tempat perlindungan, katakan \"LAPOR\" / \"CURHAT\".\n";
					$message .= "Apabila kekerasan telah terjadi pada dirimu, katakan \"PERLINDUNGAN\" / \"SAFEHOUSE\".";
					$textMessageBuilder = new TextMessageBuilder($message);
					$this->bot->replyMessage($event['replyToken'], $textMessageBuilder);
				}
	
			// if user already asking
			} else {
				if ($this->user['mode'] == "report") {
					$this->checkReport($userMessage, $event['replyToken']);
				}
			}
		}
	}

	private function stickerMessage($event)
	{
		// re-create welcome message
		$message = "Dalam keadaan darurat, katakan \"TOLONG\" / \"HELP\".\n";
		$message .= "Untuk mencari tempat perlindungan, katakan \"LAPOR\" / \"CURHAT\".\n";
		$message .= "Apabila kekerasan telah terjadi pada dirimu, katakan \"PERLINDUNGAN\" / \"SAFEHOUSE\".";
		
		$textMessageBuilder = new TextMessageBuilder($message);
		$this->bot->replyMessage($event['replyToken'], $textMessageBuilder);
	}

	public function sendQuestion($replyToken, $questionNum=1)
	{
		// get question from database
		$question = $this->bunga_m->getQuestion($questionNum);
 
		// prepare answer options
		for($opsi = "a"; $opsi <= "d"; $opsi++) {
			if (!empty($question['option_'.$opsi]))
					$options[] = new MessageTemplateActionBuilder($question['option_'.$opsi], $question['option_'.$opsi]);
		}
 
		// prepare button template
		$buttonTemplate = new ButtonTemplateBuilder($question['number']."/3", $question['text'], $question['image'], $options);
 
		// build message
		$messageBuilder = new TemplateMessageBuilder("Silahkan gunakan LINE Mobile App.", $buttonTemplate);
 
		// send message
		$response = $this->bot->replyMessage($replyToken, $messageBuilder);
	}

	private function checkHelp($userMessage, $replyToken)
	{
		$message = "Mohon tunggu sesaat lagi, bantuan akan segera datang.\n";
		$message .= "Beranikan dirimu dan alihkan perhatian untuk sementara waktu.";
		$textMessageBuilder = new TextMessageBuilder($message);
		$this->bot->replyMessage($replyToken, $textMessageBuilder);
		$this->bunga_m->setUserProgress($this->user['user_id'], 0);
		$this->bunga_m->setUserMode($this->user['user_id'], '');
		$this->bunga_m->resetUserTimestamp($this->user['user_id']);
	}

	private function checkReport($userMessage, $replyToken)
	{
		if ($this->user['number'] < 3) {
			if ($this->user['number'] == 2) {
				$this->bantuan = $userMessage;
			}
			// update number progress
			$this->bunga_m->setUserProgress($this->user['user_id'], $this->user['number'] + 1);

			// send next question
			$this->sendQuestion($replyToken, $this->user['number'] + 1);
		} else if ($this->user['number'] == 3) {
			if ($this->user['isTalking'] == 0) {
				$message = "Okay, sekarang ceritakan pengalamanmu (boleh berupa text, gambar, maupun suara).\n";
				$message .= "Bila sudah selesai, sebutkan kata \"SELESAI\"";
				$textMessageBuilder = new TextMessageBuilder($message);
				$this->bot->replyMessage($replyToken, $textMessageBuilder);

				$this->bunga_m->setUserTalking($this->user['user_id'], 1);
			}
			
			if ($userMessage == 'selesai') {
				// end of survey message
				$message = "Terima Kasih banyak telah menceritakan pengalaman kamu.\n";
				$message .= "Saya akan mencarikan bantuan untuk membantu kamu\n\n";
				$message .= "Tetap semangat Sister, we got your back!";
				$textMessageBuilder = new TextMessageBuilder($message);

				// create sticker message
				$stickerMessageBuilder = new StickerMessageBuilder(1, 2);

				// merge all message
				$multiMessageBuilder = new MultiMessageBuilder();
				$multiMessageBuilder->add($textMessageBuilder);
				$multiMessageBuilder->add($stickerMessageBuilder);

				// send reply message
				$this->bot->replyMessage($replyToken, $multiMessageBuilder);
				$this->bunga_m->setUserProgress($this->user['user_id'], 0);
				$this->bunga_m->setUserTalking($this->user['user_id'], '');
				$this->bunga_m->resetUserTimestamp($this->user['user_id']);
			}
		}
	}

	private function locationMessage($event)
	{
		if ($this->user['mode'] == "safehouse") {
			$this->checkSafeHouse($userMessage, $event);
		} else if ($this->user['mode'] == "help") {
			$this->checkHelp($userMessage, $event['replyToken']);
		}
	}

	private function checkSafeHouse($userMessage, $event)
	{
		$message = "";
		$safe = false;
		try {
			$lat = $event['message']['latitude'];
			$long = $event['message']['longitude'];
	
			$safehouses = $this->bunga_m->getActiveSafehouse();
			foreach ($safehouses as $safehouse) {
				$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat.",".$long."&destinations=".$safehouse['latitude'].",".$safehouse['longitude']."&mode=driving&language=pl-PL";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec($ch);
				curl_close($ch);
				$response_a = json_decode($response, true);
				$dist = $response_a['rows'][0]['elements'][0]['distance']['value'] / 1000;

				if ($dist <= $safehouse['radius']) {
					$message .= "Hubungi " . $safehouse['pic1'] . " pada " . $safehouse['phone1'] . " \n";
					$message .= "atau \n";
					$message .= "hubungi " . $safehouse['pic2'] . " pada " . $safehouse['phone2'] . " \n";
					$message .= "Saya berharap anda akan segera tiba di safehouse.";
					$safe = true;
					break;
				}
			}

			if (!$safe) {
				$message .= "Maaf, safehouse tidak ditemukan.";
			}

		} catch (Exception $e) {
			$message .= $e->getMessage();
		}
		
		$textMessageBuilder = new TextMessageBuilder($message);
		$this->bot->replyMessage($event['replyToken'], $textMessageBuilder);

		$this->bunga_m->setUserProgress($this->user['user_id'], 0);
		$this->bunga_m->setUserMode($this->user['user_id'], '');
		$this->bunga_m->resetUserTimestamp($this->user['user_id']);
	}

	function getDrivingDistance($lat1, $long1, $lat2, $long2)
	{
		$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response, true);
		$dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
		return "asd";
	}
}