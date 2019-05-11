<?php
	$this->load->view('profile/profile_header_view', array('title' => $layArray['title']));

	$this->load->view($layArray['content'], $layArray['data']);
	
	$this->load->view('profile/profile_footer_view');