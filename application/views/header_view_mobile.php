<?=doctype('html5');?>
<html>
	<head>
		<?php if ($this->session->userdata('logged_in')&& isset($username)):?>
			<title><?=$title." - ".$name?></title>
		<? else: ?>
			<title><?=$title?></title>
		<?php endif;?>
	<style>
		html,body{margin:0;padding:0;background:#fff;}
		a{text-decoration:none;max-width:50px;color:#0069d6;}
		a:hover{text-decoration:underline;}
		a:visited{color:#0069d6}
		#content{min-height:650px;}
		#header ul{margin:0; display:inline;}
		#header li, #footer li{list-style: none; display: inline;}
		#header,#footer {background-color:#62cffc;}
		#header{margin:0;width:100%;}
		#footer{padding-bottom:30px;}
		#footer ul{margin:0; display:inline;}
	</style>
		<script type="text/javascript">
			base_url = '<?= base_url();?>index.php/';
		</script>
		<script src="<?=base_url()."search_script/"?>prototype.js" type="text/javascript"></script>
		<script src="<?=base_url()."search_script/"?>scriptaculous.js" type="text/javascript"></script>
		<script type="text/javascript" src="<?=base_url()?>search_script/search.js"></script>
		<script src="<?=base_url()?>/jquery/jquery.min.js"></script>
		<script>
			jQuery.noConflict();
		</script>

	</head>
	<body>
			<div id="header">
			<ul><?php if ($this->session->userdata('logged_in')&& isset($username)):?>
				
				<li>	
					<span> Welcome: <a href="#"> <?=$username?></a>. </span>
					<a href="<?=base_url().'index.php/home/logout'?>"><span> Logout</span> </a> 
				</li>
				<?php else:?>

				
				<li>
					<span>Login:</span>
						<form id="login_form" action="<?=base_url()?>index.php/home/login" method="post" accept-charset="utf-8">
							<input type="text" name="nick"/>
							<input type="password" name="password"/>
							<input type="hidden" name="mobile" value="true"/>
							<input type="submit" value="Login"/>
						</form>
				</li> 
				<?php endif; ?>
				<li> <a href="<?=base_url().'index.php/home/'?>"><span>Home</span> </a> </li>
				<li> <a href="<?=base_url().'index.php/home/create'?>"><span>Create Playlist</span> </a> </li>
				
				<li id="search_box">	

				<form accept-charset="utf-8" method="POST" id="search_form" action="<?=base_url().'index.php/home/search'?>">
				 <input type="text" id="autocomplete" name="quote"/>
				
				 <input type="submit" value="Details"/>
				</form>
				</li>
			</ul>
			
		</div>