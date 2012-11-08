	<div id="margin-left">
		
		<div id="create_form_div">
			<form  id="create_pl_form" action="<?=base_url()?>index.php/home/create_status" method="post">
				<span>Playlist name:</span><br/>
				<input id="pl_name_field" type="text" name="Name"/><br/><br/>
				<span>Playlist tags:</span><br/>
				<input id="tags_field" type="text" name="Tags"/><br/><br/>
				<span>Playlist description:</span><br/>
				<input id="description_field" type="text" name="description"/><br/>
				<input id="author_field" type="hidden" value="<?=$username?>" name="Author"/><br/>
				<input type="submit" onclick=" create_pl(); return false;" value="Create"/>		
			</form>	
		</div>
		<div id="error_div" style="
			width:210px;
			min-height:20px;
			border:1px solid #ccc;
			background-color:#fcfcfc;
			display:none;
			padding-left:10px;
			padding-top:10px;
			padding-bottom:10px;
			border-radius:5px;
			box-shadow:0pt 0pt 2px #aaa, 0pt 0pt 2px #aaa;
		">
			<img src="<?=base_url()."img/ajax-loader.gif"?>" alt="loading"/>
		</div>
	</div>