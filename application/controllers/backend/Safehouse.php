<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Safehouse extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();
		$this->load->model('bunga_m');
	}
	
	public function index()
	{
		$this->data['title'] = 'Safehouse';
		$this->data['page'] = 'safehouse';
		$this->data['safehouse'] = $this->getAllSafehouse();
		$this->load->view('backend/header', $this->data);
		$this->load->view('backend/'.$this->data['page']);
		$this->load->view('backend/footer');
	}

	public function getAllSafehouse()
	{
		$data = $this->bunga_m->getAllSafehouse();
		$safehouse = [];
		for ($i=0; $i < count($data); $i++) {
			$temp = array(
				'id' => $data[$i]['id'],
				'address' => $data[$i]['safehouse_name'],
				'lat' => $data[$i]['latitude'],
				'lng' => $data[$i]['longitude'],
				'center' => array('lat' => $data[$i]['latitude'], 'lng' => $data[$i]['longitude']),
				'pic_name1' => $data[$i]['pic1'],
				'pic_contact1' => $data[$i]['phone1'],
				'pic_name2' => $data[$i]['pic2'],
				'pic_contact2' => $data[$i]['phone2'],
				'radius' => $data[$i]['radius'] * 100,
				'is_active' => $data[$i]['is_active'],
				'title' => $data[$i]['safehouse_name'],
				'index' => $i
			);
			array_push($safehouse, $temp);
		}
		return json_encode($safehouse);
	}

	public function save()
	{
		if($this->input->post('submitBtn') == "saveBtn") {
			$data = [
				'safehouse_name' => $_POST['txtAddress'],
				'latitude' => $_POST['txtLatitude'],
				'longitude' => $_POST['txtLongitude'],
				'radius' => $_POST['txtRadius'],
				'pic1' => $_POST['txtNamaPIC1'],
				'phone1' => $_POST['txtKontakPIC1'],
				'pic2' => $_POST['txtNamaPIC2'],
				'phone2' => $_POST['txtKontakPIC2'],
				'is_active' => isset($_POST['chkAktif']) ? 1 : 0
			];
			if ($_POST['txtId'] == "") {
				$this->bunga_m->addSafehouse($data);
			}
			else {
				$this->bunga_m->setSafehouse($data, $_POST['txtId']);
			}

		} else if($this->input->post('submitBtn') == "removeBtn") {
			$this->bunga_m->removeSafehouse($_POST['txtId']);
		}

		$this->index();
	}
}
