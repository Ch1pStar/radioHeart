		<div id="margin-left" >


				<div class="home_cnt_box" >
				
				<span class="label notice">Showing all playlists:</span>
				<div class="row show-grid main_display">
					<?php
						foreach($Pls as $name):?>
							<?php $target = base_url()."index.php/home/listen/".$name->Name;?>
							<a href="<?=$target?>" onclick="listen('<?=$name->Name?>');return false;">	<div class="span2"> <?= $this->edit_pl_model->displayCover($name->Name); ?> <br/><?=str_replace("-"," ",$name->Display_Name)?> </div></a>
						<?php endforeach;?>
							<br/><br/>
				</div>
				<br/><br/>
				<br/><br/>
				<br/><br/>
				<br/><br/>
				<div class="pag_links_wrap">
					<ul id ="index_pags" class="pag_links">
						<?=$pag_links?>
					</ul>
				</div>
				</div>
		<!--
			<?php if ($this->session->userdata('logged_in')):?>
				<div class="home_cnt_box" style="margin-top:800px;">
				<span class="label notice move_bitch">My playlists:</span>
				<div class="row show-grid main_display">
						<?php
							$this->db->where('Author', $username);
							$this->db->where('is_published','yes');
							$query = $this->db->get('playlists');
							foreach($query->result() as $name):?>
								<?php $target = base_url()."index.php/home/listen/".$name->Name;?>
								<a href="<?=$target?>" onclick="listen('<?=$name->Name?>');return false;">	<div class="span2"><?=str_replace("-"," ",$name->Name)?> </div></a>
							<?php endforeach;?>
				</div>
				</div>
			<?php endif;?>
		-->
			</div>