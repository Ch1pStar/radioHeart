			<span>Register:</span><br/><br/>
			<div id="register" class="register_box">
				
				<form  id="register_form" action="<?=base_url()?>index.php/home/register" method="post">
					<span>Username:</span><br/>
					<input type="text" id="usr_nick_field" name="nick"/><br/><br/>
					<span>Name:</span><br/>
					<input type="text" id="usr_name_field" name="name"/><br/><br/>
					<span>Password:</span><br/>
					<input type="password" id="usr_password_field" name="password"/><br/> <br/>
					<span>Repeat password:</span><br/>
					<input type="password" id="usr_password_field_confirm" name="password_confirm"/><br/><br/>
					<input type="submit" value="Register"/><br/>
				</form>
				<div id="register_status" style="
					width:210px;
					min-height:20px;
					border:1px solid #ccc;
					background-color:#fcfcfc;
					margin-bottom:20px;
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
		</div>