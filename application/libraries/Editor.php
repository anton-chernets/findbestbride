<?php

Class Editor
{
	function __construct()
	{
		log_message('debug', 'Editor class initialized');
	}
	
	
	function parse_message($message)
	{
		$message = preg_replace('#(http|www)[^\s]+#is', '', $message);
		$message = preg_replace('/([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+/i', '', $message);
		
		$message = str_replace("<", "&lt;", $message);
		$message = str_replace(">", "&gt;", $message);
		$message = str_replace("\n", "<br/>", $message);
		
		return $message;
	}
	
	function smiles($message)
	{
		$message = preg_replace('#:(.*):#sUi', '<img src="'.base_url().'content/chat/smiles/$1.gif" style="width: 20px; height: 20px;">', $message);
		
		return $message;
	}
}