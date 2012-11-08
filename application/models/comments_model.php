<?php
class Comments_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function addComment($comment){
		
	}
	
	function showComments($pl_name){
		$this->db->where('playlist',$pl_name);
		$this->db->order_by('date','desc');
		$query=$this->db->get('comments');
		$output=null;
		foreach($query->result() as $row){
			$output .='<div class="single_comment">';
			$output .="<span>".$row->author." - ";
			$output .=$row->date."<br/></span>";
			$output .="<span>".$row->content."</span>";
			$output .='</div>';
		}
		echo $output;
	}
}
?>