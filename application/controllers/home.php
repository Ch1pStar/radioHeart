<?php
	class Home extends CI_Controller{
	
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
			$this->load->model('tags_model');
			$this->load->model('home_model');
			$this->load->model('profile_model');
			$this->load->library('pagination');


		}
		
		public function index($offset=null){
			$data['title'] = "radioHeart";
			
			
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
			}
			
			$total = $this->home_model->playlistsCount();
			$limit = 15;
			
			$config['base_url'] = base_url()."index.php/home/index/";
			$config['total_rows'] = $total;
			$config['per_page'] = $limit;

			$this->pagination->initialize($config);

			$data['pag_links'] = $this->pagination->create_links();	
			
			$data['Pls'] = $this->home_model->getAllPls($limit, $offset);
			
			if(IS_AJAX)
				$this->load->view('homeAjax_view', $data);
			else
			$this->load->view('home_view', $data);
		}
		
		public function homeAjax($offset=null){
			if(IS_AJAX){
				$data['title'] = "radioHeart";
				
				
				if($this->session->userdata('logged_in')){
					$data['username'] = $this->session->userdata('nick');
					$data['name'] = $this->session->userdata('name');
				}
			
				$total = $this->home_model->playlistsCount();
				$limit = 15;
				
				$config['base_url'] = base_url()."index.php/home/index/";
				$config['total_rows'] = $total;
				$config['per_page'] = $limit;

				$this->pagination->initialize($config);

				$data['pag_links'] = $this->pagination->create_links();	
				
				$data['Pls'] = $this->home_model->getAllPls($limit, $offset);
				
				$this->load->view('homeAjax_view', $data);
			} else redirect('home');
		}
		public function register(){
			$password_confirm=$this->input->post('password_confirm');
			$info['nick'] = addslashes($this->input->post('nick'));
			$info['name'] = addslashes($this->input->post('name'));
			if(strlen($this->input->post('password'))>3){
				if($password_confirm==$this->input->post('password')){
					$info['password'] = md5(addslashes($this->input->post('password')));
					echo $this->register_model->register($info);
				}else echo "<span>Passwords not matching!</span>";
			}else echo "<span>Password needs to be atleast 4 characters long.</span>";
		}
		
		function reg_page(){
			$data['title'] = "register";
			if(IS_AJAX)
				$this->load->view('registerAjax_view', $data);
			else $this->load->view('register_view', $data);
		}
		
		function login(){
			
			$username=$this->input->post('nick');
			$password=md5($this->input->post('password'));
			
			
			$login = $this->db->get('users');
			$user;

			foreach($login->result() as $info){
				if(strtolower($username)==strtolower($info->nick) && $password==$info->password){
					$newdata = array(
						'curr_page'=> current_url(),
						'nick'  => $info->nick,
						'name' => $info->name,
						'logged_in' => TRUE
					);
					$this->session->set_userdata($newdata);
				}
			}
			if($this->input->post('mobile')=='true')redirect('m');
			else
				redirect('home');
		}
		
		function logout(){
			$this->session->sess_destroy();
			redirect('home');
		}
		
		function user($user=null,$offset=null){
				error_reporting(E_ALL ^ E_DEPRECATED);
			$data['title'] = "User not found - radioHeart";
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
				if(isset($user)){
					$this->db->where('nick', $user);
					$query = $this->db->get('users');
					if ($query->num_rows() > 0){
						$data['user_name'] = $this->edit_pl_model->getUserDisplayName($user);
						$data['title'] = $this->edit_pl_model->getUserDisplayName($user)." - radioHeart";
						
						$total = $this->profile_model->playlistsCount($user);
						$limit = 5;
						
						$config['uri_segment'] = 4;
						$config['base_url'] = base_url()."index.php/home/user/$user";
						$config['total_rows'] = $total;
						$config['per_page'] = $limit;

						$this->pagination->initialize($config);

						$data['pag_links'] = $this->pagination->create_links();	
						$data['createdPls'] = $this->profile_model->getAllPlsFrom($user, $limit, $offset);
						
						if(IS_AJAX)	
							$this->load->view('profileAJAX_view',$data);
						else
							$this->load->view('profile_view',$data);
					} else $this->load->view('404_view',$data);
				}else $this->load->view('404_view',$data);
		}
		
		function not_found(){
			$data['title'] = "radioHeart ";
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
			}
			if(IS_AJAX)
				$this->load->view('404Ajax_view',$data);
			else $this->load->view('404_view',$data);
		}
		
		function loader_gif(){
			if(IS_AJAX)
				echo "<img src=\"".base_url()."img/ajax-loader.gif"."\" alt=\"loading\"/>";
			else redirect('home');
		}
		
		function whatILike(){
			error_reporting(E_ALL ^ E_DEPRECATED);
			$data['title'] = "What I Like - radioHeart ";
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');	
			}else{
				if(IS_AJAX) echo "<p>You need to be logged in to use this feature.</p>";
				else
				$this->load->view('not_logged_view',$data);
				return;
			}
			if(IS_AJAX)
				echo $this->search_model->getLikedPlaylists($this->session->userdata('nick'));
			else $this->load->view('whatILike_view',$data);
		}
		

		
		function addcomment(){
			if(isset($_POST['content']) && $_POST['content']!=""){
				$this->db->insert('comments', $_POST);
				$this->comments_model->showComments($_POST['playlist']);
			} else{
				echo "Enter a comment first";
			}
		}
		

		function like($pl_name){
			$view_data['title'] = "radioHeart";
			if($this->session->userdata('logged_in')){
				$this->db->where('nick', $this->session->userdata('nick'));
				$this->db->select('liked_playlists');
				$query = $this->db->get('users');
				foreach($query->result() as $row){
					$old_likes = $row->liked_playlists;
				}
					
				if(strpos($old_likes, $pl_name)){
					echo "Playlist already liked.";
					return;
				}else{
					$old_likes .=" ";
					$old_likes .=$pl_name;
				}
				$data['liked_playlists'] = $old_likes;
				$this->db->where('nick', $this->session->userdata('nick'));
				$this->db->update('users', $data);
				$output = "<div id=\"unlike_btn_id\" class=\"like_btn\">
						<form method=\"post\" id=\"unlike_form\" action=\"".base_url()."index.php/home/unlike\">
							<input type=\"hidden\" id=\"Pl_name\" value=\"$pl_name\" name=\"playlist\"/>
							<input type=\"submit\" onclick=\"new Ajax.Updater ('like_btn_wrap', base_url+'home/unlike/".$pl_name."',{});return false;\" value=\"Unlike\"/>
						</form>
					</div>";
				echo $output;
			} else $this->load->view('not_logged_view',$view_data);
		}
		
		function unlike($pl_name){
			$view_data['title'] = "radioHeart";
			if($this->session->userdata('logged_in')){
				$this->db->where('nick', $this->session->userdata('nick'));
				$this->db->select('liked_playlists');
				$query = $this->db->get('users');
				foreach($query->result() as $row){
					$old_likes = $row->liked_playlists;
				}
					
				if(strpos($old_likes, $pl_name)){
					$a =  $this->edit_pl_model->rstrstr($old_likes,$pl_name);
					$b =  (substr(strstr($old_likes,$pl_name),strlen($pl_name)));
					$old_likes = $a;
					$old_likes .= $b;
				}else{
					echo "You need to like the playlist first.";
					return;
				}
				$data['liked_playlists'] = $old_likes;
				$this->db->where('nick', $this->session->userdata('nick'));
				$this->db->update('users', $data);
				$output = "<div id=\"like_btn_id\" class=\"like_btn\">
						<form method=\"post\" id=\"like_form\" action=\"".base_url()."index.php/home/like\">
							<input type=\"hidden\" id=\"Pl_name\" value=\"$pl_name\" name=\"playlist\"/>
							<input type=\"submit\" onclick=\"new Ajax.Updater ('like_btn_wrap', base_url+'home/like/".$pl_name."',{});return false;\" value=\"Like\"/>
						</form>
					</div>";
				echo $output;
			}else $this->load->view('not_logged_view',$view_data);
		}
		
		function saveSong(){
				$this->edit_pl_model->saveSong($_POST);
				$this->edit_pl_model->showTracks($_POST['Playlists']);
		}
		
		function addCover(){
				$this->edit_pl_model->addCover($_POST);
				echo $this->edit_pl_model->displayCover($_POST['Name']);
		}
		
		function deleteSong(){
			$this->edit_pl_model->deleteTrack($_POST);
			$this->edit_pl_model->showTracks($_POST['Playlists']);
		}
		
		
		function search($quote=null){
			$data['title'] = "Search results - radioHeart ";
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');	
			}
			if(isset($quote)){
				$data['quote'] = $quote;
				$data['search_results'] = $this->search_model->getSearchResults($quote);
				$output  = $this->load->view('search_view', $data, true);
				$this->output->set_output($output);
			}else{
				$this->load->view('404_view',$data);
			}
		}
		
		function tag($tag=null){
			$data['title'] = "radioHeart ";
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');	
			}
			if(isset($tag)){
				$data['title'] = "$tag - radioHeart ";
				$data['quote'] = $tag;
				$data['search_results'] = $this->tags_model->getTaggedPlaylists($tag);
				$output  = $this->load->view('search_view', $data, true);
				$this->output->set_output($output);
			}else{
				$this->load->view('404_view',$data);
			}
		}
		
		function ajaxsearch(){
			$quote = $this->input->post('quote');
			$description = $this->input->post('description');
			if($description!=""){
				echo $this->search_model->getSearchResultsAjax($quote, $description);
			} else {
				echo $this->search_model->getSearchResultsAjaxSimple($quote);
			}
		}
		

		function fillPlaylists(){
			$tracks = array(
				'Author' => 'Nedelin',
				'Name' => 'Pl2',
				'Tags' => 'Upsurt, blabla, herp, derp',
				'Rating' => '5',
				'Tracks' => 'T_2, T_3',				
			);
			$this->db->insert('playlists', $tracks);
		}
				
		function fillTracks(){
			$tracks = array(
				'T_Name' => 'T_2',
				'T_Author' => 'pRo',
				'T_Lenght' => '1:25',
				'T_Album' => 'Something2',
				'Playlists' => 'Pl1, Pl2',				
			);
			$this->db->insert('tracks', $tracks);
		}
		
		
		function getTest(){
			$query = $this->db->query("SELECT * FROM tracks where Playlists = 'Pl1'");
			foreach($query->result() as $row){
				echo $row->T_Name."</br>";
			}
		}
		
		function displayPL($playList){
			$this->db->where('Playlists', $playList);
			$query = $this->db->get('tracks');

			foreach($query->result() as $row){
				echo $row->T_Name."</br>";
				echo $row->T_Author."</br>";
				echo $row->T_Album."</br>";
			}
		}
		
		function createPlPage(){
			redirect(base_url()."index.php/home/createPlPage1/".$this->session->userdata('nick'));
		}
		
		function startNewPL(){
			for($i=1000;$i<9000;$i++){
				$data['Author'] = "TEST";
				$data['Name'] = "Test-number-$i";
				$data['is_published'] = "yes";
				$songData['T_Name'] = "Song-$i";
				$songData['url'] = "Song-$i.mp3";
				$songData['Playlists'] = "Test-number-$i";
				$songData['T_Author'] = "TEST";
				if($this->db->insert('playlists',$data))
					echo "Done<br/>";
				if($this->db->insert('tracks',$songData))
					echo "Done song <br/>";
					
			}
		}
		
		
/* ***************** D*E*P*R*E*C*A*T*E*D **************************** */
		function createPlPage1($user = null){
		
			$data['title'] = "radioHeart";
			$data['author'] = null;
			$data['error'] = null;
			if(isset($_GET['Pl_name']) && $_GET['Pl_name']!=""){
				$this->db->where('Name', $_GET['Pl_name']);
				$this->db->where('Author', $user);
				$query = $this->db->get('playlists');
				foreach($query->result() as $row){
					$data['author']=$row->Author;
				}
				if(!file_exists("./php/playlists/".$_GET['Pl_name'])){
						mkdir("./php/playlists/".$_GET['Pl_name'], 0777);
						$plInfo = array(
						   'Author' =>$user,
						   'Name' => $_GET['Pl_name'],
						   'Tags' => $_GET['tags']
						);
						$this->db->insert('playlists', $plInfo);
				}
			
				if( $data['author']==$user ){

					$data['Pl_name'] = $_GET['Pl_name'];
				
				}
			}else $data['error'] = "Playlist name not specified.";	
			
			$output = null;
			if($this->session->userdata('logged_in')){
				if($this->session->userdata('nick')==$user){
			
					$data['username'] = $this->session->userdata('nick');
					$data['name'] = $this->session->userdata('name');
					$output  = $this->load->view('header_view', $data, true);
					$output .= $this->load->view('createPL_view', $data, true);	
					

					
				}else {echo $output .= $this->load->view('404_view', $data, true);}
				
			}else{
					$output .= $this->load->view('not_logged_view', $data, true);
			}
				
			$output .= $this->load->view('footer_view', $data, true);
			$this->output->set_output($output);
		}
/* *************************************************************************************** */
	
		function create(){
			$data['title'] = "Create Playlist - radioHeart";
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
					
				if(IS_AJAX)
					echo $this->load->view('createAjax_view', $data);
				else $this->load->view('create_view', $data);
				
			} else if(!IS_AJAX){
				$this->load->view('not_logged_view', $data);
			} else echo "<p>You need to be logged in to use this feature.</p>";
		}
		
		function create_status(){
			$info = $this->input->post();
			$info['Name'] = str_replace(" ", "-", $this->input->post('Name'));
			echo $this->create_pl_model->create($info);
		}
		
		function publish(){
			
				$pl_name = $_POST['pl_name'];
				$query=$this->edit_pl_model->getTracks($pl_name);
				if ($query->num_rows() > 0){
					
					$data['is_published'] = 'yes';
					$this->db->where('Name', $pl_name);
					$this->db->update('playlists', $data);
					echo "Playlist published!";
					
				} else echo "Cannot publish an empty playlist!";
			
		}
		
		function edit($pl_name=null){
				$data['title'] = "Edit Playlist - radioHeart";
				if($this->session->userdata('logged_in')){
				
					$data['username'] = $this->session->userdata('nick');
					$data['name'] = $this->session->userdata('name');
					if(isset($pl_name)){
					
						$pl_name = $this->edit_pl_model->getPlDisplayName($pl_name);
						$pl_display_name = str_replace("-", " ", $pl_name);
						$data['title'] = "Edit $pl_display_name - radioHeart";
						$data['pl_name'] = $pl_name;					
						$user = $this->session->userdata('nick');
						$this->db->where('Name', $pl_name);
						$this->db->where('Author', $user);
						$query = $this->db->get('playlists');
						
						foreach($query->result() as $row){
							$existing = $row->Name;
						}
						if(!isset($existing) || strtolower($pl_name)!=strtolower($existing)){
							$this->load->view('not_found_view', $data);
						}
						else {
							if(IS_AJAX)
								$this->load->view('editAjax_view', $data);
							else 
								$this->load->view('edit_view', $data);
						}
					} else $this->load->view('404_view', $data);
					
				}else $this->load->view('not_logged_view', $data);
				
		}
		
		function listen2(){
			$data['title'] = "radioHeart";
			$data['id'] = $this->session->userdata('session_id');
			
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
		
			$output  = $this->load->view('listen_view', $data, true);
			$this->output->set_output($output);
		}
	
/*
		function do_upload(){
			$config['upload_path'] = './songs/';
			$config['allowed_types'] = 'mp3';
			$config['max_size']	= '100000';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$data = array('error' => $this->upload->display_errors());

				//$this->load->view('home_view', $data);
				redirect(base_url()."index.php/home/createPlPage");
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());

			//	$this->load->view('upload_success', $data);
				redirect(base_url()."index.php/home/createPlPage");
			}
		}
*/		
		function do_upload(){
		
			$upload_path_url = base_url().'img/';
			
			$config['upload_path'] = FCPATH.'img/';
			$config['allowed_types'] = 'jpg';
			$config['max_size']	= '100000';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$data = array('error' => $this->upload->display_errors());

				//$this->load->view('home_view', $data);
				redirect(base_url()."index.php/home/createPlPage");
			}
			else
			{
				//$data = array('upload_data' => $this->upload->data());
			//	redirect(base_url()."index.php/home/createPlPage");
				$data = $this->upload->data();
				
				$info->name = $data['file_name'];
				$info->size = $data['file_size'];
				$info->type = $data['file_type'];
				$info->url = $upload_path_url .$data['file_name'];
				$info->thumbnail_url = $upload_path_url .$data['file_name'];//I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
				$info->delete_url = base_url().'upload/deleteImage/'.$data['file_name'];
				$info->delete_type = 'DELETE';
					
				if (IS_AJAX) {   //this is why we put this in the constants to pass only json data
					echo json_encode(array($info));
                    //this has to be the only the only data returned or you will get an error.
                    //if you don't give this a json array it will give you a Empty file upload result error
                    //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
                      }
				else{   // so that this will still work if javascript is not enabled
						$file_data['upload_data'] = $this->upload->data();
						$this->load->view('admin/upload_success', $file_data);
				}
			}
		}
		
	
		function createPlayList($playList = null){
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
				$data['title'] = "radioHeart";
				$data['id'] = $this->session->userdata('session_id');
				
					$data['username'] = $this->session->userdata('nick');
					$data['name'] = $this->session->userdata('name');
				
				if ( ! write_file('./player/'.$this->input->ip_address().'.'.$_SERVER['REMOTE_PORT'].'songs.xml', $data['xml'])){
					 echo 'Unable to write the file';
				}
				else{
					$output  = $this->load->view('listen_view', $data, true);
					$this->output->set_output($output);
				}
			}else redirect(base_url());
		}
		
		function getHash(){
			if(IS_AJAX){
				$pl_name = substr($this->input->post('hash'),8,strlen($this->input->post('hash')));
				if($this->create_pl_model->plExists($pl_name))
					echo $pl_name;
				else return false;
			}
			else redirect('home');
		}
		
		function listen($playList = null){
			$data['title'] = "Playlist doesnt exist - radioHeart";
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
			}
			if($playList!=null && isset($playList)){
				$playList = $this->edit_pl_model->getPlDisplayName($playList);
				$pl_display_name = str_replace("-", " ", $playList);
				$this->db->where('Playlists', $playList);
				$query = $this->db->get('tracks');
				if ($query->num_rows() > 0){
					$data['title'] = "$pl_display_name - radioHeart";
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
					
					$data['id'] = $this->session->userdata('session_id');
				
					$data['username'] = $this->session->userdata('nick');
					$data['name'] = $this->session->userdata('name');
					
					if ( ! write_file('./player/'.$this->input->ip_address().'.'.$_SERVER['REMOTE_PORT'].'songs.xml', $data['xml'])){
						 echo 'Unable to write the file';
					}
					else{
						$output  = $this->load->view('listen_view', $data, true);
						$this->output->set_output($output);
					}
				} else $this->load->view('404_view', $data);
			}else echo redirect(base_url());
		}
		
		function listenAjax($playList = null){
			$data['title'] = "Playlist doesnt exist - radioHeart";
			if($this->session->userdata('logged_in')){
				$data['username'] = $this->session->userdata('nick');
				$data['name'] = $this->session->userdata('name');
			}
			if($playList!=null && isset($playList)){
				$playList = $this->edit_pl_model->getPlDisplayName($playList);
				$pl_display_name = str_replace("-", " ", $playList);			

				$this->db->where('Playlists', $playList);
				$query = $this->db->get('tracks');
				if ($query->num_rows() > 0){
					$data['title'] = "$pl_display_name - radioHeart";
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
					
					$data['id'] = $this->session->userdata('session_id');
				
					$data['username'] = $this->session->userdata('nick');
					$data['name'] = $this->session->userdata('name');
					
					if ( ! write_file('./player/'.$this->input->ip_address().'.'.$_SERVER['REMOTE_PORT'].'songs.xml', $data['xml'])){
						 echo 'Unable to write the file';
					}
					else{
						$this->load->view('listenAjax_view', $data);
					}
				} else $this->load->view('404Ajax_view', $data);
			}else $this->load->view('404Ajax_view', $data);
		}
		
		function edit_pl_title($pl_name){
			//if(isset($POST['pl_name'])){
			$data['Display_Name'] = $this->input->post('pl_name');
			$this->db->where('Name', $pl_name);
			$this->db->update('playlists',$data);
			echo $this->input->post('pl_name');
			//}else echo "nope";
		}
		
		function edit_track_title(){
			$data['T_Name'] = $this->input->post('tName');
			$track_name = $this->input->post('currName');
			$this->db->where('T_Name', $track_name);
			$this->db->update('tracks',$data);
			echo $this->input->post('tName');
		
		}
	}
?>