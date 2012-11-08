<?php
class Edit_pl_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function getTracks($pl_name){
		$this->db->where('Playlists',$pl_name);
		$query=$this->db->get('tracks');
		return $query;
	}
	
	function showTracks($pl_name){
		$this->db->where('Playlists',$pl_name);
		$query=$this->db->get('tracks');
		$output=null;
		foreach($query->result() as $row){
			$tName = "'".$row->T_Name."'";
			$pName = "'".$row->Playlists."'";
			$form_id = "'edit_track_name'";
			$output .='<div class="single_comment track"> ';
			$output .="<div style=\"color:#666;\" id=\"$row->T_Name\">$row->T_Name</div>";
			$output .= "<a href=\"#\" onclick=\"panda($tName); return false;\" id='edit_link' >Edit</a>";
			$output .='<div style="color:#111111;" id="'.$row->T_Author.'">'.$row->T_Author.'</div>';
			$output .= "<form id='edit_track_name' method='post' action='#' style='display:none;'>";
			$output .= "<input type=\"text\" id=\"pandas\" style=\"width:150px;\"/>";
			$output .= "<input type=\"hidden\" value=\"$row->T_Name\" />";
			$output .= '<input type="submit" value="save"/>';
			$output .= '</form>';
			$output .="<a onclick=\"delete_try($tName, $pName);return false;\"  href=\"#\">Delete</a></div>";
		}
		echo $output;
	}
	
	function showTracksNoDelete($pl_name){
		$this->db->where('Playlists',$pl_name);
		$query=$this->db->get('tracks');
		$output=null;
		foreach($query->result() as $row){
			$tName="'".$row->T_Name."'";
			$pName="'".$row->Playlists."'";
			$output .='<div class="single_comment track"> ';
			$output .='<div id="'.$row->T_Name.'">'.$row->T_Name.'</div><br/><br/>';
			$output .='<div id="'.$row->T_Author.'">'.$row->T_Author.'</div><br/><br/>';
			$output .="</div>";
		}
		echo $output;
	}
	
	function getPlAuthor($pl_name){
		$this->db->where('Name',$pl_name);
		$this->db->select('Author');
		$query = $this->db->get('playlists');
		foreach($query->result() as $row){
			$author = $row->Author;
		}
		return $author;
	}
	
	function saveSong($info){	
		$this->db->where('Playlists',$info['Playlists']);
		$this->db->where('T_Name',$info['T_Name']);
		$query=$this->db->get('tracks');
		
		if ($query->num_rows() > 0){
			echo "<span>Track already in the playlist!</span>";
		}else{
			$this->db->insert('tracks', $info);
		}
	}
	
	function getPlDisplayName($pl_name=null){
		if(isset($pl_name)){
			$this->db->where('Name',$pl_name);
			$this->db->select('Name');
			$query = $this->db->get('playlists');
			foreach($query->result() as $row){
				$displayName = $row->Name;
			}
			if(isset($displayName))
			return $displayName;
		}
	}
	
	function getPlDisplayNameNew($pl_name=null){
		if(isset($pl_name)){
			$this->db->where('Name',$pl_name);
			$this->db->select('Display_Name');
			$query = $this->db->get('playlists');
			foreach($query->result() as $row){
				$displayName = $row->Display_Name;
			}
			if(isset($displayName))
			return $displayName;
		}
	}
	
	function getUserDisplayName($user_name=null){
		if(isset($user_name)){
			$this->db->where('nick',$user_name);
			$this->db->select('nick');
			$query = $this->db->get('users');
			foreach($query->result() as $row){
				$displayName = $row->nick;
			}
			if(isset($displayName))
			return $displayName;
		}
	}
	
	function deleteTrack($plInfo){
		$this->db->where('Playlists',$plInfo['Playlists']);
		$query=$this->db->get('tracks');		
		if ($query->num_rows() > 1){
						
			$this->db->where('Playlists',$plInfo['Playlists']);
			$this->db->where('T_Name',$plInfo['track']);
			$query=$this->db->get('tracks');
			foreach($query->result() as $row){
				$file_path ='php/playlists/'.$row->Playlists.'/'.$row->url;
			}	
			if(unlink($file_path)){
				$this->db->where('Playlists',$plInfo['Playlists']);
				$this->db->where('T_Name',$plInfo['track']);
				$this->db->delete('tracks');
			} else echo "Error: Unable to delete track!";
		} else echo "<span>Playlist must have alteast one track!</span>";
	}
	
	function addCover($info){
		$this->db->where('Name',$info['Name']);
		$this->db->select('label');
		$query=$this->db->get('playlists');
		
		foreach ($query->result() as $row){
				$data['label'] = $info['label'];
				$this->db->where('Name',$info['Name']);
				$this->db->update('playlists', $data);
		}
	}
	
	function addDefaultCover($pl_name){
		$this->db->where('Name',$pl_name);
		$this->db->select('label');
		$query=$this->db->get('playlists');
		
		if ($query->num_rows() > 0){
				$data['label'] = 'default.gif';
				$this->db->where('Name',$pl_name);
				$this->db->update('playlists', $data);
		}
	}
	
	function displayCover($pl_name){
		$this->db->where('Name',$pl_name);
		$this->db->select('label');
		$query=$this->db->get('playlists');
		foreach ($query->result() as $row){
			return "<img src=\"".base_url()."php/playlists/$row->label\" />" ;
		}
	}
	
	function deleteAllTracks($pl_name){
		$this->db->where('Playlists',$pl_name);
		$query=$this->db->delete('tracks');
	}
	
	function rstrstr($haystack,$needle){
		return substr($haystack, 0,strpos($haystack, $needle));
	}
	

}
?>