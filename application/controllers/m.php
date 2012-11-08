<?php
	class M extends CI_Controller{
	
		public function __construct(){
			parent::__construct();
			
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->library('session');
			$this->load->library('Xml_writer');
			$this->load->helper('array');
			$this->load->helper('file');
			$this->load->helper('html');
			$this->load->database();
			$this->load->model('search_model');
			$this->load->model('create_pl_model');
			$this->load->model('register_model');
			$this->load->model('comments_model');
			$this->load->model('edit_pl_model');
		
		}
		
		public function index(){
			$data['title'] = "Mobile - welcome to radioHeart";
			
			
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
			}
			
			
			$this->load->view('home_view_mobile', $data);
		}
		
		function listen($playList = null){
			if($playList!=null && isset($playList)){
				$this->db->where('Playlists', $playList);
				$query = $this->db->get('tracks');
				$xml = new Xml_writer;
				$xml->setRootName('songs');
				$xml->initiate();
				foreach($query->result() as $row){
					$xml->startBranch('track');
					$xml->addNode('title', $row->T_Name);
					$xml->addNode('artist', $row->T_Author);
					$xml->addNode('url', base_url().'php/playlists/'.$row->Playlists.'/'.$row->url);
					$xml->endBranch();
				}
				$data['xml'] = $xml->getXml();
				$data['title'] = "$playList - radioHeart";
				$data['id'] = $this->session->userdata('session_id');
			
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
				
				if ( ! write_file('./player/'.$this->input->ip_address().'.'.$_SERVER['REMOTE_PORT'].'songs.xml', $data['xml'])){
					 echo 'Unable to write the file';
				}
				else{
					$output  = $this->load->view('listen_view_mobile', $data, true);
					$this->output->set_output($output);
				}
			}else echo redirect(base_url());
		}
		
}?>