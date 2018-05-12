<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database('mysql');
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
    }
    
	public function staff()
	{
			$this->data['title'] = 'Kelola Staff';
			$this->data['page'] = 'staff';
			$this->load->view('backend/header', $this->data);

			$crud = new grocery_CRUD();
			$crud->set_table('staff');
			$crud->set_subject('Staff');
			$crud->columns('fullname','username','rolename');
			$crud->display_as('fullname','Nama Lengkap')
				 ->display_as('username','Username')
				 ->display_as('rolename','Peran');
			$crud->set_relation('rolename','roles','rolename');
			$crud->fields('fullname','username','rolename');
			$crud->add_fields('fullname','username','password','rolename');
			$crud->edit_fields('fullname','password','rolename');
			$crud->required_fields('fullname','username','password');
			$crud->change_field_type('password','password');
			$output = $crud->render();
			$this->load->view('backend/'.$this->data['page'], (array)$output);

			$this->load->view('backend/footer');
	}

	public function questions()
	{
		$this->data['title'] = 'Kelola Kuesioner';
		$this->data['page'] = 'questions';
		$this->load->view('backend/header', $this->data);

		$crud = new grocery_CRUD();
		$crud->set_table('questions');
		$crud->set_subject('Kuesioner');
		$crud->columns('number','texts','image', 'option_a', 'option_b', 'option_c', 'option_d');
		$crud->display_as('number','Urutan')
			 ->display_as('texts','Pertanyaan')
			 ->display_as('image','Link Gambar')
			 ->display_as('option_a','Pilihan A')
			 ->display_as('option_b','Pilihan B')
			 ->display_as('option_c','Pilihan C')
			 ->display_as('option_d','Pilihan D');
		$crud->add_fields('number','texts','image', 'option_a', 'option_b', 'option_c', 'option_d');
		$crud->edit_fields('number','texts','image', 'option_a', 'option_b', 'option_c', 'option_d');
		$crud->required_fields('number','texts','option_a','option_b');
		$output = $crud->render();
		$this->load->view('backend/'.$this->data['page'], (array)$output);

		$this->load->view('backend/footer');
	}

}
