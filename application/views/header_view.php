<?php echo doctype('html5');
	error_reporting(E_ALL ^ E_DEPRECATED);
?>
<html>
	<head>
		<?php if ($this->session->userdata('logged_in')&& isset($username)):?>
			<title><?=$title." - ".$name?></title>
		<? else: ?>
			<title><?=$title?></title>
		<?php endif;?>
		<link rel="stylesheet" href="<?=base_url()?>css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=base_url()?>css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="<?=base_url()?>css/bootstrap-image-gallery.min.css">
		<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/bootstrap-ie6.min.css"><![endif]-->
		<link rel="stylesheet" href="<?=base_url()?>css/jquery.fileupload-ui.css">
		
		<script src="<?=base_url()."search_script/"?>prototype.js" type="text/javascript"></script>
		<script src="<?=base_url()."search_script/"?>scriptaculous.js" type="text/javascript"></script>
		<script src="<?=base_url()."search_script/"?>effects.js" type="text/javascript"></script>
		<script src="<?=base_url()."search_script/"?>controls.js" type="text/javascript"></script>


		
		<script src="<?=base_url()?>/jquery/jquery.min.js"></script>
		<script>
			jQuery.noConflict();
		</script>
		<script type="text/javascript">
			base_url = '<?= base_url();?>index.php/';
		</script>
		
		<script src="<?=base_url()."uploader_script/"?>jquery.ui.widget.js"></script>
		
		<script src="<?=base_url()."uploader_script/"?>tmpl.min.js"></script>
		
		<script src="<?=base_url()."uploader_script/"?>jquery.fileupload.js"></script>
		<script src="<?=base_url()."uploader_script/"?>jquery.fileupload-ui.js"></script>
		<script src="<?=base_url()."uploader_script/"?>uploader.js"></script>
		<script src="<?=base_url()."uploader_script/"?>jquery.postmessage-transport.js"></script>
		<script src="<?=base_url()."uploader_script/"?>jquery.xdr-transport.js"></script>
		
			
		<script type="text/javascript" src="<?=base_url()?>search_script/search.js"></script>
		
	</head>
	<body>
		
		<div id="wrap" onclick = "hide_results();">
		<div id="header">
			<ul>
				<li id="search_box">	

				<form accept-charset="utf-8" method="POST" id="search_form" action="<?=base_url().'index.php/home/search'?>">
				 <input type="text" id="autocomplete" name="quote"/>
				
				 <input type="submit" value="Details"/>
				</form>
				</li>
			<!--	<li>
					<img class="logo" src="<?=base_url()?>img/cassette.png" />
				</li>
			-->

				<li> <a href="<?=base_url().'index.php/home/'?>" onclick="index(); return false;"><span>Home</span> </a> </li>
				<?php if ($this->session->userdata('logged_in')&& isset($username)):?>
				<li> <a href="<?=base_url().'index.php/home/create'?>" onclick="create(); return false;"><span>Create Playlist</span> </a> </li>
				<?php else: ?>
					<li> <a href="<?=base_url().'index.php/home/reg_page'?>" onclick="reg_page(); return false;"><span>Register</span> </a> </li>
				<?php endif; ?>
				<?php if ($this->session->userdata('logged_in')&& isset($username)):?>
					
					<li>
						<a href="<?=base_url()."index.php/home/#What I like"?>" onclick="whatILike(); return false;"><span>What I like </span></a>
					</li>
					<li>
						<span> Welcome: <a href="<?=base_url()."index.php/home/user/$username"?>" onclick="profile('<?=$username?>'); return false;"> <?=$username?></a>. </span>
						<a href="<?=base_url().'index.php/home/logout'?>"><span> Logout</span> </a> 

					</li>

				<?php else:?>
				<li>
					
						<span>Login:</span>
					<div id="login_box">
						<form id="login_form" action="<?=base_url()?>index.php/home/login" method="post" accept-charset="utf-8">
							<input type="text" name="nick"/>
							<input type="password" name="password"/>
							<input type="submit" value="Login"/>
						</form>
					</div>
				</li> 
				<?php endif; ?>
				
			</ul>
			
		</div>
		<div id="autocomplete_choices" class="autocomplete"></div>
		<div id="details_wrap" style="position:absolute;margin-left:1250px;display:none;">
			<div id="appear_demo"  
			style="position:absolute;
			  width:250px;
			  background-color:white;
			  border:1px solid #ccc;
			  margin:0;
			  padding:0;
			  color:#666;
			  margin-top:20px;
			  margin-left:-200px;
			  -moz-border-radius:5px;
			  display:none;
			  overflow:auto;
			  z-index:1;"
			>
				<img src="<?=base_url()."img/ajax-loader.gif"?>" alt="loading"/>
			</div>
			<p>
				<img class="close-small" onclick="$('appear_demo').hide(); $('details_wrap').hide();return false;"  alt="remove" src="<?=base_url()."css/pixel.gif"?>" title="close ">
			</p>
		</div>