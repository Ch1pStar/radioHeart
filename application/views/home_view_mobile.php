<?php
	$this->load->view('header_view_mobile');
?>
		<div id="content">	
		<div id="margin-left">
				<div class="home_cnt_box" ">
				<span class="label notice">Showing all playlists:</span><br/>
					<?php
						$this->db->where('is_published','yes');
						$playlist = $this->db->get('playlists');
						foreach($playlist->result() as $name):?>
							<?php $target = base_url()."index.php/m/listen/".$name->Name;?>
						<a href="<?=$target?>"><span>	<?=$name->Name?> <span></a><br/>
						<?php endforeach;?>
							<br/><br/>
				</div>
		</div>
		</div>

<?php
	$this->load->view('footer_view_mobile');
?>	