<?php

	$this->load->view('admin/main/admin_header_view', array('title' => $layArray['title']));
	
	$this->load->view($layArray['content'], $layArray['data']);
	
	$this->load->view('admin/main/admin_footer_view');
