		<div id="content">
		<div id="left-border">
		<div id="margin-left">
			<?php if(!isset($Pl_name)):?>
				<div id="upload_form">
						<span>Enter Playlist name:</span>
						<form action="<?=base_url().'index.php/home/createPlPage1/'.$username?>" method="get">
							<input type="text" name="Pl_name"/><br/><br/>
							<span>Enter playlist tags here:</span><br/>
							<input type="text" name="tags"/> <br/><br/>
							
							<input type="submit" value="Create Playlist"/>
						</form>
						<p><?=$error?></p>
				</div>
			<?php else:?>
				<h3><?=$Pl_name?></h3>
				<form id="fileupload" action="<?=base_url()?>php/index.php" method="POST" enctype="multipart/form-data">
							<div class="row">
								<div class="span16 fileupload-buttonbar">
									<div class="progressbar fileupload-progressbar fade"><div style="width:0%;"></div></div>
									<span class="btn success fileinput-button">
										<span>Add files...</span>
										<input type="file" name="files[]"  multiple>
									</span>
									<button type="button" class="btn danger delete">Delete selected</button>
									<input type="checkbox" class="toggle">
									<input type="hidden" name="Pl_name" value="<?=$_GET['Pl_name']?>">
								</div>
							</div>
							<br>
							<div class="row">
								<div class="span16">
									<table class="zebra-striped"><tbody class="files"></tbody></table>
								</div>
							</div>
					</form>
							<form id="fileupload" action="#" method="POST">
								<div class="row">
									<div class="span16">
										<button type="submit" id="save_pl" class="btn success fileinput-button">Save Playlist</button>
									</div>
								</div>
							</form>
			<?php endif;?>
		</div>
		</div>
		</div>