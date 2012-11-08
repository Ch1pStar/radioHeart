<?php
class Home_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function playlistsCount(){
		$this->db->where('is_published','yes');
		$query = $this->db->get('playlists');
		return $query->num_rows();
	}
	
	function getAllPls($limit, $offset){
		$this->db->where('is_published','yes');
		$this->db->order_by('id', 'desc');
		$this->db->limit($limit, $offset);
		$playlist = $this->db->get('playlists');
		return $playlist->result();
	}
	
	
}
?>