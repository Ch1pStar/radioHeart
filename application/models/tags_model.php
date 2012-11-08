<?php
class Tags_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function getTaggedPlaylists($tag){
		//$this->db->like('Tags', $tag);
		//$this->db->where('T_Id', 10);
		//$this->db->select('P_Id');
		//$lolwut = $this->db->get('p_t_linker');
		
		//$this->db->where_in('Id', $lolwut);
		//$query = $this->db->get('playlists');
		$this->db->where('Name', $tag);
		$this->db->select('id');
		$tag_Id = $this->db->get('tags');
		if($tag_Id->num_rows()>0){
		$wat =  $tag_Id->row(0);
		
		$query = $this->db->query("select * from playlists where id in(select P_Id from p_t_linker where T_Id=$wat->id)");
		
		if($query->num_rows()>0){
			$output = '<div class="row show-grid offset1">';
			foreach($query->result() as $info){
						$link = base_url().'index.php/home/listen/'.$info->Name;
						$img =$this->edit_pl_model->displayCover($info->Name);
						$output .= '<a href="'.$link.'">'."<div class=\"span2\">". "$img <br/>". str_replace("-"," ",$info->Name);
						$output .= '</div></a>';
				}
		//		$output .= $this->db->last_query();
				$output .= '</div>';
				return $output;
		} else {
		//	return $this->db->last_query();
			return '<div class="span4"><p> There are no playlists tagged as '.'"'.$tag.'"'.'</p></div>';
		}
		} else return '<br/><div class="span4"><p> There are no playlists tagged as '.'"'.$tag.'"'.'</p></div>';
	}
	
	function getPlTags($pl){
		$output = null;
		$query = $this->db->query("select id from playlists where Name ='$pl'");
		$row = $query->row(0);
		$pl_id = $row->id;
		$base_url = base_url()."index.php/home/tag/";
		$query = $this->db->query("select * from tags where id in(select T_Id from p_t_linker where P_Id=$pl_id)");
		foreach($query->result() as $tag){
			$output .= "<a href='$base_url".$tag->Name."'>$tag->Name </a>";
		}
		return $output;
	
	}
	
	
	
}
?>