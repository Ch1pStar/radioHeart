<?php

	$pl_name = $this->edit_pl_model->getPlDisplayName($pl_name);
	$pl_display_name = str_replace("-", " ", $pl_name);
	
?>
	<div id="content">
	<div id="margin-left">
		<div class="pl_title edit_view"><a href="<?=base_url()."index.php/home/listen/".$pl_display_name?>"><?=$pl_display_name?></a></div>
	
		<br/>
		<form id="fileupload" action="<?=base_url()?>php/index.php" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="span16 fileupload-buttonbar">
					<div class="progressbar fileupload-progressbar fade"><div style="width:0%;"></div></div>
					<span class="btn success fileinput-button">
						<span>Add files...</span>
						<input type="file" name="files[]"  multiple>
					</span>
					<input type="hidden" id="Pl_name" name="Pl_name" value="<?=$pl_name?>">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="span7">
					<table class="zebra-striped"><tbody class="files"></tbody></table>
				</div>
			</div>
		</form>
		<?php 
		//	$query=$this->edit_pl_model->getTracks($this->uri->segment(3));
		//	if (!$query->num_rows() > 0):
		?>
		<form id="save_pl_form" action="#" method="POST">
			<div class="row">
				<div class="span16">
					<button type="submit" id="save_pl" class="btn success fileinput-button">Publish Playlist</button>
				
					<div id="edit_error_div" style="
						width:210px;
						min-height:20px;
						border:1px solid #ccc;
						background-color:#fcfcfc;
						display:none;
						padding-left:10px;
						padding-top:10px;
						padding-bottom:10px;
						border-radius:5px;
						margin-left:150px;
						box-shadow:0pt 0pt 2px #aaa, 0pt 0pt 2px #aaa;
					">
						<img src="<?=base_url()."img/ajax-loader.gif"?>" alt="loading"/>
					</div>
			</div>
		</form>
		<?php //endif;?>

		
		</div>
			
			<div id="playlist_cover"  
			style="
			  max-width:200px;
			  max-height:200px;
			  margin:0;
			  padding:0;
			  color:#666;
			  margin-top:-150px;
			  margin-left:778px;
			  -moz-border-radius:5px;
			  position:absolute;
			  overflow:auto;"
			>	
				<?= $this->edit_pl_model->displayCover($pl_name);?>
			</div>
		
			<div id="playlist_songs" class="tracks_box edit" >	
				<?php $this->edit_pl_model->showTracks($pl_name);?>
			</div>
	</div>
<script>
	var fileUploadErrors = {
		maxFileSize: 'File is too big',
		minFileSize: 'File is too small',
		acceptFileTypes: 'This is not a music file',
		maxNumberOfFiles: 'Max number of files exceeded',
		uploadedBytes: 'Uploaded bytes exceed file size',
		emptyResult: 'Empty file upload result'
	};
</script>
	<script id="template-download" type="text/html">
			{% 
			for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { a=file.size; b=2;c=3;d=4; %}
				
				<tr class="template-download fade" id="{%=a*2%}">
					{% if (file.error) { %}
						<td class="name">{%=file.name%}</td>
						<td class="size">{%=o.formatFileSize(file.size)%}</td>
						<td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
						<td class="delete">
							<button class="btn danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">Remove</button>
						</td>
					{% } else { 
							if(file.type=="audio/mpeg"){
								a=file.size;
								new Ajax.Updater('playlist_songs',base_url+'home/saveSong', {method:'post', postBody:'T_Name='+file.name+'&T_Author= &Playlists=<?=$pl_name?>&url='+file.name});						
							} else {
								new Ajax.Updater('playlist_cover',base_url+'home/addCover', {method:'post', postBody:'T_Name='+file.name+'&T_Author= &Name=<?=$pl_name?>&label=<?=$pl_name?>/'+file.name});						
							
							}
					%}
						<td class="name">
							<span>Title:</span>
							<span>{%=file.name%}</span>
						</td>
						
					{% } %}

				</tr>
			{%
			} %}
		</script>
		</script>
	<script id="template-upload" type="text/html">
		{% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
			<tr class="template-upload fade">
				<td class="name">{%=file.name%}</td>
				<td class="size">{%=o.formatFileSize(file.size)%}</td>
				{% if (file.error) { %}
					<td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
					 <td class="cancel">{% if (!i) { %}
						<button class="btn btn-warning">
							<i class="icon-ban-circle icon-white"></i> Cancel
						</button>
						{% } %}
					</td>
				{% } else if (o.files.valid && !i) { %}
					<td class="progress"><div class="progressbar"><div style="width:0%;"></div></div></td>
				{% }
				%}
			</tr>
		{% } %}
	</script>
