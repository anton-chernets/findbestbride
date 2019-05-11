<?php 
	$this->load->view('general/general_header_view', array('title' => $layArray['title'], 'keywords' => $layArray['keywords'], 'description' => $layArray['description']));
	
	$this->load->view($layArray['content'], $layArray['data']);
	
	$this->load->view('general/general_footer_view');
?>