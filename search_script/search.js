window.onload = function(){
	new Ajax.Autocompleter("autocomplete", "autocomplete_choices", base_url+"home/ajaxsearch", {});
	
	
	
	$('search_form').onsubmit = function () {
	
		search_results();
		return false;	
	}
	try{
		$('create_pl_form').onsubmit = function () {	
			create_pl()		
			return false;	
		}
	} catch(e){}

	try{
		$('register_form').onsubmit = function () {
		
			register();
			return false;	
		}
	} catch(e){}
	
	try{
		$('add_comment_form').onsubmit = function () {
			$('blank_status').hide();
			if($F('content_area')!=""){
					new Ajax.Updater ('comments_box', base_url+'home/addcomment', {method:'post', postBody:'content='+$F('content_area')+'&author='+$F('author_field')+'&playlist='+$F('playlist_field')});
			} else{ 
				new Ajax.Updater ('blank_status', base_url+'home/addcomment', {method:'post', postBody:'content='+$F('content_area')+'&author='+$F('author_field')+'&playlist='+$F('playlist_field')});
				$('blank_status').appear();
			}
			return false;	
		}
	} catch(e){}

	try{
		$('save_pl_form').onsubmit = function () {
			new Ajax.Updater ('edit_error_div', base_url+'home/publish', {method:'post', postBody:'pl_name='+$F('Pl_name')});	
			$('edit_error_div').appear();
			
			return false;
		}
	} catch(e){
		//alert(e.message);
	}

	
	try{
		$('like_form').onsubmit = function () {
			new Ajax.Updater ('like_btn_wrap', base_url+'home/like/'+$F('Pl_name'),{});	
			
			return false;
		}
	} catch(e){
	}
	/*
	try{
		$('unlike_form').onsubmit = function () {
		//	new Ajax.Updater ('like_btn_wrap', base_url+'home/unlike/Mitov',{});	
			return false;
		}
	} catch(e){
	}
*/
	switch(location.hash){
		case "#create":
			
			create();
			break;
		case "#home":
			index();
			break;
		case "#What I like":
			whatILike();
			break;
		case "#register":
			reg_page();
			break;
	}
	/*
	for(i=0; i<allPlNamesLen; i++){
		if (location.hash === "#listen/"+allPlNames[i]) {
			listen(allPlNames[i]);
			
		}
	}
	*/
	try{
		jQuery('#index_pags > li a').live('click', function(e){
			e.preventDefault();
			//jQuery('#margin-left').slideUp('slow', function() {
				var link = jQuery(this).attr('href');
				new Ajax.Updater('margin-left',link,{});
			//});
			jQuery('#margin-left').slideDown('slow');
			parent.location.hash="page";
		});
	} catch(e){}
	
	try{
		jQuery('#profile_pags > li a').live('click', function(e){
			e.preventDefault();
			//jQuery('#margin-left').slideUp('slow', function() {
				var link = jQuery(this).attr('href');
				new Ajax.Updater('margin-left',link,{});
			//});
			jQuery('#margin-left').slideDown('slow');
			parent.location.hash="page";
		});
	} catch(e){}
	

	/*
	if(pl_exists){
		listen(pl_Name);
	}
	*/
/*
	if(allPlNames.find(location.hash)!=false){
		if(location.hash.substr(0,8)=="#listen/")
			listen(location.hash.substr(8,location.hash.lenght));
		else if(location.hash.substr(0,6)=="#edit/")
			edit(location.hash.substr(6,location.hash.lenght));
	}
*/
window.onhashchange = locationHashChanged;

}

function search_results(){
	new Ajax.Updater ('appear_demo', base_url+'home/ajaxsearch', {method:'post', postBody:'description=true&quote='+$F('autocomplete')});
	
	$('details_wrap').appear();
	$('appear_demo').appear();
}

function create_pl(){

	new Ajax.Updater ('error_div', base_url+'home/create_status', {method:'post', postBody:'description='+$F('description_field')+'&Name='+$F('pl_name_field')+'&Tags='+$F('tags_field')+'&Author='+$F('author_field')});
	
	//$('create_form_div').hide();
	$('error_div').appear();
}

function register(){
	new Ajax.Updater ('register_status', base_url+'home/register', {method:'post', postBody:'nick='+$F('usr_nick_field')+'&name='+$F('usr_name_field')+'&password='+$F('usr_password_field')+'&password_confirm='+$F('usr_password_field_confirm')});
	$('register_status').appear();
		
}

function addComment(){

	
			if($F('content_area')!=''){
				new Ajax.Updater ('comments_box', base_url+'home/addcomment', {method:'post', postBody:'content='+$F('content_area')+'&author='+$F('author_field')+'&playlist='+$F('playlist_field')});
				Form.Element.setValue("content_area","");
			}else{
				new Ajax.Updater ('blank_status', base_url+'home/addcomment', {method:'post', postBody:'content='+$F('content_area')+'&author='+$F('author_field')+'&playlist='+$F('playlist_field')});
				$('blank_status').appear();
			}
}

function delete_try(tName, pName){
	new Ajax.Updater ('playlist_songs', base_url+'home/deleteSong', {method:'post', postBody:'Playlists='+pName+'&track='+tName});

}

function pls_work(pl_name){
	new Ajax.Updater ('like_btn_wrap', base_url+'home/unlike/'+pl_name,{});
}

function pls_workToo(pl_name){
	new Ajax.Updater ('like_btn_wrap', base_url+'home/like/'+pl_name,{});
}

function whatILike(){

	jQuery('#margin-left').slideUp('slow', function() {
		new Ajax.Updater('margin-left', base_url+'home/whatIlike',{});
	});
	jQuery('#margin-left').slideDown('slow');
	parent.location.hash = "What I like";
	return false;
}

function listen(pl_name){
	
	jQuery('#margin-left').slideUp('slow', function() {
		new Ajax.Updater('margin-left', base_url+'home/listenAjax/'+pl_name,{});
	});
	jQuery('#margin-left').slideDown('slow');
	parent.location.hash = "listen/"+pl_name;
	return false;
}

function index(offset){
	jQuery('#margin-left').slideUp(1000, function() {
		if(offset=="")
			new Ajax.Updater('margin-left', base_url+'home/homeAjax/',{});
		else new Ajax.Updater('margin-left', base_url+'home/homeAjax/'+offset,{});
	});
	jQuery('#margin-left').slideDown(1000);
	parent.location.hash="home";
	return false;
}

function create(){
	jQuery('#margin-left').slideUp('slow', function() {
		new Ajax.Updater('margin-left', base_url+'home/create',{});
	});
	jQuery('#margin-left').slideDown('slow');
	parent.location.hash="create";
	return false;
}

function profile(user){
	jQuery('#margin-left').slideUp('slow', function() {
		new Ajax.Updater('margin-left', base_url+'home/user/'+user,{});
	});
	jQuery('#margin-left').slideDown('slow');
	parent.location.hash="user/"+user;
	return false;
}

function edit(pl_name){
	jQuery('#margin-left').slideUp('slow', function() {
		new Ajax.Updater('margin-left', base_url+'home/edit/'+pl_name,{});
	});
	jQuery('#margin-left').slideDown('slow');
	parent.location.hash="edit/"+pl_name;
	return false;
}

function edits(pl_name){
	alert(pl_name);
}

function not_found(){
//	new Ajax.Updater('content', base_url+'home/loader_gif',{});
	new Ajax.Updater('margin-left', base_url+'home/not_found',{});
	parent.location.hash=" ";
	return false;
}

function hide_results(){
	$('details_wrap').hide();
}

function locationHashChanged() {
    if (location.hash === "#Kiro") {
      //  parent.localtion = "home/sdsad"
	//	alert(123);
	}
}
function edit_pl_title(pl_name){
	$('title_hide').hide(); 
	$('title_edit_form').appear();
	$('title_edit_form').onsubmit = function () {
		//alert($F('panda'));
		new Ajax.Updater ('title_display', base_url+'home/edit_pl_title/'+pl_name, {method:'post', postBody:'pl_name='+$F('panda')});
		$('title_hide').appear(); 
		$('title_edit_form').hide();
		return false;
	}
}

function edit_track_title(track_name){
	$('edit_link').hide(); 
	$('edit_track_name').appear();
	$('edit_track_name').onsubmit = function () {
		//new Ajax.Updater ('title_display', base_url+'home/edit_pl_title/'+pl_name, {method:'post', postBody:'pl_name='+$F('panda')});
		$('edit_link').appear(); 
		$('edit_track_name').hide();
		return false;
	}
}

function panda(track_name){
	$('edit_link').hide(); 
	$('edit_track_name').appear();
	$('edit_track_name').onsubmit = function () {
		new Ajax.Updater (track_name, base_url+'home/edit_track_title/', {method:'post', postBody:'tName='+$F('pandas')+'&currName='+track_name});
		$('edit_link').appear(); 
		$('edit_track_name').hide();
		return false;
	}
}

function reg_page(){
	jQuery('#margin-left').slideUp('slow', function() {
		new Ajax.Updater('margin-left', base_url+'home/reg_page',{});
	});
	jQuery('#margin-left').slideDown('slow');
	parent.location.hash="register";
	return false;
}

Array.prototype.find = function(searchStr) {
  var returnArray = false;
  for (i=0; i<this.length; i++) {
    if (typeof(searchStr) == 'function') {
      if (searchStr.test(this[i])) {
        if (!returnArray) { returnArray = [] }
        returnArray.push(i);
      }
    } else {
      if (this[i]===searchStr) {
        if (!returnArray) { returnArray = [] }
        returnArray.push(i);
      }
    }
  }
  return returnArray;
}

pl_exists = false;
new Ajax.Request (base_url+'home/getHash/',{
	method:'post', 
	postBody:'hash='+location.hash, 
	onSuccess: function(transport) {
		if(transport.responseText!=""){
			pl_Name= transport.responseText;
			pl_exists = true;
			listen(pl_Name);
		}
	}
});	

