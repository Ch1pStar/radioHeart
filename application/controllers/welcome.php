<?php
class Welcome extends CI_Controller {

	function __construct(){
		
		parent::__construct();

		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->database();
	}	
	
	public function index(){
		$data['title'] = "Welcome to radioHeart";
		$this->load->view('welcome_message',$data);
	}

	function reg(){	
	//	$this->db->insert('radioHeart', $_POST);
		redirect('.');
	}
}
?>
