<?php

	$this->load->view('partner/main/partner_header_view', array('title' => $layArray['title']));
	
	$this->load->view($layArray['content'], $layArray['data']);
	
	$this->load->view('partner/main/partner_footer_view');
