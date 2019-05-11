<?php

Class Api
{
	private $secret = '';
	private $token  = '';
	private $server = '';
	
	function request($page)
	{
		$get = file_get_contents('http://192.168.1.199/mob/api/'.$page);
		
		return json_decode($get);
	}
}