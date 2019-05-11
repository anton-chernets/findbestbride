<?php 
	$this->load->view('content/content_header_view', array('title' => $layArray['title'], 'description' => $layArray['description'], 'keywords' => $layArray['keywords']));
	
	$this->load->view($layArray['content'], $layArray['data']);
	
	$this->load->view('content/content_footer_view');
?>