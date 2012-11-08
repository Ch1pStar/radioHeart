<?php
	$this->load->view('header_view_mobile');
?>
	<?php
		$pl_name = $this->edit_pl_model->getPlDisplayName($this->uri->segment(3));
		$pl_display_name = str_replace("-", " ", $pl_name);
	?>

	<div id="content">	
		<div id="left-border">
	<div class="pl_title"><?=$pl_display_name?></div>
		<div id="flashContent">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="600" height="100" id="SoundPlayer" align="middle">
				<param name="movie" value="<?=base_url()?>player/SoundPlayer.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<PARAM NAME="FlashVars" VALUE="ip=<?=$this->input->ip_address()?>"/>
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="<?=base_url()?>player/SoundPlayer.swf" width="600" height="100">
					<param name="movie" value="<?=base_url()?>player/SoundPlayer.swf"/>
					<param name="quality" value="high" />
					<PARAM NAME="FlashVars" VALUE="ip=<?=$this->input->ip_address().'.'.$_SERVER['REMOTE_PORT']?>"/>
					<param name="bgcolor" value="#ffffff" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
				<!--<![endif]-->
					
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
			<?php if($this->session->userdata('logged_in')):?>
			<div id="like_btn_wrap">
			<?php 
				$this->db->where('nick', $this->session->userdata('nick'));
				$this->db->select('liked_playlists');
				$query = $this->db->get('users');
				foreach($query->result() as $row){
					$old_likes = $row->liked_playlists;
				}
					
				if(strpos($old_likes, $pl_name)){?>
					
					<div id="unlike_btn_id" class="like_btn">
						<form method="post" id="unlike_form" action="<?=base_url()?>index.php/home/unlike">
							<input type="hidden" id="Pl_name" value="<?=$pl_name?>" name="playlist"/>
							<input type="submit" onclick="pls_work(<?="'".$pl_name."'"?>);return false;" value="Unlike"/>
						</form>
					</div>
					<?php 
				}else{?>
					<div id="like_btn_id" class="like_btn">
							<form method="post" id="like_form" action="<?=base_url()?>index.php/home/like">
								<input type="hidden" id="Pl_name" value="<?=$pl_name?>" name="playlist"/>
								<input type="submit" onclick="pls_workToo(<?="'".$pl_name."'"?>);return false;" value="Like"/>
							</form>
					</div>
				<?php }?>
			</div>
			<?php endif;?>
		</div>

			<div id="playlist_songs" class="tracks_box">	
				<?php if($this->edit_pl_model->getPlAuthor($pl_name)==$username){
					$this->edit_pl_model->showTracks($pl_name);	
				}else{
					$this->edit_pl_model->showTracksNoDelete($pl_name);
				}?>
			</div>
			<?php if ($this->session->userdata('logged_in')&& isset($username)):?>
				<div id="add_comment">
					<form method="post" id="add_comment_form" action="<?=base_url()?>index.php/home/addcomment">
						<textarea name="content" id="content_area"></textarea><br/> 
						<input type="hidden"  id="author_field" value="<?=$username?>" name="author"/>
						<input type="hidden" id="playlist_field" value="<?=$pl_name?>" name="playlist"/>
						<br/><br/>
						<input type="submit" onclick=" addComment();
						return false;
						" value="Add comment"/>
					</form>
				</div>
				<div id="blank_status" style="
					width:210px;
					min-height:20px;
					border:1px solid #ccc;
					background-color:#fcfcfc;
					margin-bottom:20px;
					margin-top:-55px;
					margin-left:150px;
					display:none;
					padding-left:10px;
					padding-top:10px;
					padding-bottom:10px;
					border-radius:5px;
				">
					<img src="<?=base_url()."img/ajax-loader.gif"?>" alt="loading"/>
				</div>
			<?php endif;?>
		<div id="comments_box" class="comments_box_class">
			
			<?php 
				 $this->comments_model->showComments($pl_name);
			?>
		</div>
	</div>
	
	</div>

<?php
	$this->load->view('footer_view_mobile');
?>	