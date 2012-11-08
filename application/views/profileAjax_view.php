
		
			<div id="left-border">
				<div class="pl_title"><?=$user_name?></div>
				<div id="margin-left">
				<div class="home_cnt_box" style="margin-top:20px;">
				<span class="label notice move_bitch">Playlists from <?=$user_name?>:</span>
				<div class="row show-grid main_display">
					<?php
						foreach($createdPls as $name):?>
							<?php $target = base_url()."index.php/home/listen/".$name->Name;?>
						<a href="<?=$target?>" onclick="listen('<?=$name->Name?>');return false;">	<div class="span2"> <?= $this->edit_pl_model->displayCover($name->Name); ?> <br/><?=str_replace("-"," ",$name->Name)?> </div></a>
						<?php endforeach;?>
				</div>
				<div class="pag_links_wrap profile_pags_wrap">
					<ul id="profile_pags" class="pag_links">
						<?=$pag_links?>
					</ul>
				</div>
				</div>
				<div class="home_cnt_box" style="margin-top: -150px;">
				<span class="label notice move_bitch">Playlists liked by <?=$user_name?>:</span>
				
						<?php
							echo $this->search_model->getLikedPlaylists($user_name);
						?>
				</div>
			</div>
		</div>