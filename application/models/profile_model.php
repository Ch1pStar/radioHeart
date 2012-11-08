<?php
class Profile_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function getAllPlsFrom($user, $limit, $offset){
		$this->db->where('is_published','yes');
		$this->db->where('Author', $user);
		$this->db->order_by('id', 'desc');
		$this->db->limit($limit, $offset);
		$playlist = $this->db->get('playlists');
		return $playlist->result();
	}
	
	function playlistsCount($user){
		$this->db->where('is_published','yes');
		$this->db->where('Author', $user);
		$query = $this->db->get('playlists');
		return $query->num_rows();
	}
	
	function getAllLikedPlsFrom($user, $limit, $offset){
		$this->db->where('is_published','yes');
		$this->db->where('Author', $user);
		$this->db->order_by('id', 'desc');
		$this->db->limit($limit, $offset);
		$playlist = $this->db->get('playlists');
		return $playlist->result();
	}
	
	function likedPlaylistsCount($user){
		$this->db->where('is_published','yes');
		$this->db->where('Author', $user);
		$query = $this->db->get('playlists');
		return $query->num_rows();
	}
	
}
?>