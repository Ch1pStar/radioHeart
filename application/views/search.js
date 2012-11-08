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
		case "":
			//index();
			break;
		case "#What I like":
			whatILike();
			break;	
	}
	
	for(i=0; i<allPlNamesLen; i++){
		if (location.hash === "#listen/"+allPlNames[i]) {
			listen(allPlNames[i]);
			exists = true;
		}
	}
	
	if(!exists){
		not_found();
	}
	



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

//	new Ajax.Updater('content', base_url+'home/loader_gif',{});
	new Ajax.Updater('content', base_url+'home/whatIlike',{});
	parent.location.hash = "What I like";
	return false;
}

function listen(pl_name){
	$('appear_demo').hide();
//	new Ajax.Updater('content', base_url+'home/loader_gif',{});
	new Ajax.Updater('content', base_url+'home/listenAjax/'+pl_name,{});
	parent.location.hash = "listen/"+pl_name;
	return false;
}

function index(){
//	new Ajax.Updater('content', base_url+'home/loader_gif',{});
	new Ajax.Updater('content', base_url+'home/homeAjax',{});
	parent.location.hash="";
	return false;
}

function create(){
//	new Ajax.Updater('content', base_url+'home/loader_gif',{});
	new Ajax.Updater('content', base_url+'home/create',{});
	parent.location.hash="create";
	return false;
}


function not_found(){
//	new Ajax.Updater('content', base_url+'home/loader_gif',{});
	new Ajax.Updater('content', base_url+'home/not_found',{});
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
