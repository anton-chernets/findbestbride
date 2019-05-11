<?php

Class Api extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}	
	
	function delete_photo($photo_name, $user_id, $req_token)
	{
		$token_check = md5('photo' . $photo_name . $user_id);

		if ($token_check == $req_token)
		{
			$this->load->model('profile_model', 'pModel');
			
			$this->pModel->deletePhoto($user_id, $photo_name);
			
			unlink('./profiles/photo/user_' . $user_id . '/' . $photo_name . '_full.jpg');
			unlink('./profiles/photo/user_' . $user_id . '/' . $photo_name . '_105.jpg');
			unlink('./profiles/photo/user_' . $user_id . '/' . $photo_name . '_170.jpg');
			
			echo json_encode(array('response' => 'success'));
		}
	}
}