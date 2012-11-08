<?php
class Create_pl_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function create($pl){
	error_reporting(E_ALL ^ E_DEPRECATED);
		if(isset($pl['Name']) && $pl['Name']!="" && isset($pl['description']) && $pl['description']!=""  && isset($pl['Tags']) && $pl['Tags']!=""){ 

			$pl_name = $pl['Name'];
			$pl['Display_Name'] = $pl['Name'];
			$pl['is_published'] = 'no';
			$this->db->where('Name', $pl_name);
			$query = $this->db->get('playlists');
			$pl_exists = false;
			foreach($query->result() as $row){
				$existing = $row->Name;
				if($pl_name==$existing) $pl_exists=true;
			}
			$tags = str_replace(" ","",$pl['Tags']);
			$tags = split(",",$tags);
			
			foreach($tags as $tag){
				$tag_exists = $this->db->query("select name from tags where name='$tag'");
				$tag_name = $tag;
				if($tag_exists->num_rows()<1){
					$tag = array("Name" => $tag);
					$this->db->insert('tags', $tag);
				}

				$this->db->where('Name', $tag_name);
				$this->db->select('id');
				$tag_Id_obj = $this->db->get('tags');
				$tag_Id =  $tag_Id_obj->row(0);
				
				$this->db->where('Name', $pl['Name']);
				$this->db->select('id');
				$pl_Id_obj = $this->db->get('playlists');
				$pl_Id = $pl_Id_obj->row(0);
				
				$pl_tagged = $this->db->query("select * from p_t_linker where P_Id = '$pl_Id->id' and T_Id = '$tag_Id->id' ");
				if($pl_tagged->num_rows()<1)
				$this->db->query("insert into p_t_linker values($pl_Id->id,$tag_Id->id)");
			/*
				echo $pl_Id->id."-".$tag_Id->id;
				echo "<br/>";
			*/
			}
			if(!$pl_exists){
				mkdir("./php/playlists/".$pl['Name'], 0777);
				$pl['label'] = "default.gif";
				$this->db->insert('playlists', $pl);
				return "<span>Playlist created!<span><br/> <span> Add songs to: <a href=\"".base_url()."index.php/home/edit/".$pl_name."\" \">".str_replace("-"," ",$pl_name)." →</a></span>";
			} else return "<span>Playlist with that name already exists.</span>";
		} else return "<span>You need to fill every field!</span>";
	}
	
	
	function getAllPls(){
		$this->db->select('Name');
		return $this->db->get('playlists');
	}
	
	function getAllPlsNamesArray(){
		$query = $this->create_pl_model->getAllPls();
		$i=0;
		foreach($query->result() as $row){
			$data[$i] = $row->Name;
			$i++;
		}
		return $data;
	}
	
	function plExists($pl_name){
		$this->db->select('Name');
		$this->db->where('is_published','yes');
		$this->db->where('Name',$pl_name);
		$query = $this->db->get('playlists');
		if ($query->num_rows() > 0)
			return true;
		else return false;
	}
}
?>
