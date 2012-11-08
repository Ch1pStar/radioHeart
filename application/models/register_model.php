<?php
class Register_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function register($info){
		if(isset($info['nick']) && $info['nick']!="" && isset($info['name']) && $info['name']!=""  && isset($info['password']) && $info['password']!=""){ 
			$nick = $info['nick'];
			$this->db->where('nick', $nick);
			$query = $this->db->get('users');
			$user_exists=false;
			foreach($query->result() as $row){
				$existing = $row->nick;
				if($nick==$existing) $user_exists=true;
			}
			if(!$user_exists){
				$this->db->insert('users', $info);
				return "Registration successful!";
			} else return '<span>User with the name '.$nick.' already exists.</span>';
		}else return "<span>You need to fill every field.</span>";
	}
}
?>