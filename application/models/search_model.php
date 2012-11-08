<?php
class Search_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}

	function getSearchResults($input, $show_description=TRUE){
		if(strpos($input, "<!")!==false){
					return '<div class="span4"><p> Really now, this is the best you could think of ? <em>;)</em></p></div>';
		} else
		if($input!=""){
			$this->db->like('Name', $input);
			$this->db->where("is_published", "yes");
			$this->db->order_by('id', 'desc');
			$query = $this->db->get('playlists');
			if($query->num_rows()>0){
				$output = '<div class="row show-grid main_display">';
				foreach($query->result() as $info){
					
						$link = base_url().'index.php/home/listen/'.$info->Name;
						$img =$this->edit_pl_model->displayCover($info->Name);
						$output .= '<a href="'.$link.'">'."<div class=\"span2\">". "$img <br/>". str_replace("-"," ",$info->Name);
						$output .= "</div></a>";
					
				}
				$output .= '</div>';
				return $output;
			} else {
				return '<div class="span4"><br/><p> No results were found for '.'"'.$input.'"'.'</p></div>';
			}
		} else return '<div class="span4"><p> You need to enter a playlist name.</p></div>';
	}
	
	function getSearchResultsAjax($input, $show_description = TRUE){
		if(strpos($input, "<!")!==false){
					return '<ul><li> Really now, this is the best you could think of? <em>;)</em></li></ul>';
		} else
		if($input!=""){
			$this->db->like('Name', $input);
			$this->db->where("is_published", "yes");
			$query = $this->db->get('playlists',5);
			if($query->num_rows()>0){
				$output = '<ul>';
				foreach($query->result() as $info){
					$link = base_url().'index.php/home/listen/'.$info->Name;
					$mitov = "'$info->Name'";
					$img =$this->edit_pl_model->displayCover($info->Name);
					$output .= "<a href=\"".$link."\" <a onclick=\"listen($mitov);return false;\") return false;\">"."<div class=\"lolo\">". " <br/>". str_replace("-"," ",$info->Name);
					$output .= "</div></a>";
				}
				$output.="<li><a href=\"".base_url()."index.php/home/search/$input\">See all results</a></li>";
			} else {
				$output = '<ul><li> No results were found for '.'"'.$input.'"'.'</li>';
			}
			
			$this->db->like('Name', $input);
			$query = $this->db->get('tags',5);
			if($query->num_rows()>0){
				//$output = '<ul>';
				$output .= '<br/><li>-------- TAGS -----------</li>';
				foreach($query->result() as $info){
					$link = base_url().'index.php/home/tag/'.$info->Name;
					$output .= '<li><a href="'.$link.'">'.'<span>'.$info->Name.'</span></a><br/>';
				}
				$output.="<li><a href=\"".base_url()."index.php/home/search/$input\">See all results</a></li>";
				$output .= '</ul>';
			} else {
				$output .=  '"'.$input.'"'.' is not a tag! </li></ul>';
			}
			
			return $output;
		} 
		else return '<ul><li> You need to enter a playlist name.</li></ul>';
	}
	
	
	function getSearchResultsAjaxSimple($input){
		if(strpos($input, "<!")!==false){
					return '<ul><li> Really now, this is the best you could think of? <em>;)</em></li></ul>';
		} else
		if($input!=""){
			$this->db->like('Name', $input);
			$this->db->where("is_published", "yes");
			$query = $this->db->get('playlists',5);
			if($query->num_rows()>0){
				$output = '<ul>';
				foreach($query->result() as $info){
						$output .= '<li>'.$info->Name.'</li>';
				}
			} else {
				$output = '<ul><li> No results were found for '.'"'.$input.'"'.'</li>';
			}
			$this->db->like('Name', $input);
			$query = $this->db->get('tags',5);
			if($query->num_rows()>0){
				$output .= '<div id="no-highlight"><br/><li>-------- TAGS -----------</li></div>';
				foreach($query->result() as $info){
					$link = base_url().'index.php/home/tag/'.$info->Name;
					$output .= '<li><a href="'.$link.'">'.'<span>'.$info->Name.'</span></a><br/>';
				}
				$output.="<li><a href=\"".base_url()."index.php/home/search/$input\">See all results</a></li>";
				$output .= '</ul>';
				
			} else {
				$output.= '<ul><li> No results were found for '.'"'.$input.'"'.'</li></ul>';
			}
			return $output;
		} 
		else return '<ul><li> You need to enter a playlist name.</li></ul>';
	}
	
	function getLikedPlaylists($user){
		$this->db->where('nick', $user);
		$this->db->select('liked_playlists');
		$query = $this->db->get('users');
		if($query->num_rows()>0){
			$output = '<div class="row show-grid main_display">';
			foreach($query->result() as $info){
						$arr = split(" ", $info->liked_playlists);
		
				}
				foreach($arr as $row){
						if($row!=""){
							$link = base_url().'index.php/home/listen/'.$row;
							$mitov = "'$row'";
							$img =$this->edit_pl_model->displayCover($row);
							$output .= "<a href=\"".$link."\" <a onclick=\"listen($mitov);return false;\") return false;\">"."<div class=\"span2\">". "$img <br/>". str_replace("-"," ",$row);
							$output .= "</div></a>";
						}
				}
				$output .= "</div>";
				return $output;
		} else {
			return '<div class="span4"><p> There are no playlists tagged as '.'"'.$tag.'"'.'</p></div>';
		}
	}

}
?>