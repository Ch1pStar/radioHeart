<?php

	$this->load->view('header_view');
	
?>


		<div id="content">
			<div id="margin-left"> 
				<?php echo $this->search_model->getLikedPlaylists($this->session->userdata('nick'));?>
			
		
<?php

	$this->load->view('footer_view');
	
?>