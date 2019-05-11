<?php

Class Favorites extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		if ($this->isAuth == false || $this->userInfo['sex'] == '2')
		{
			redirect(base_url());
			die;
		}
		
		$this->lang->load($this->language . '/profile');
		$this->load->model('profile_model', 'pModel');
	}
	
	function index()
	{
		$list = $this->pModel->getFavorites($this->selfId);
		
		$this->layout('profile', 'profile/favorites_view', array('list' => $list['list'], 'all' => $list['count']), $this->lang->line('profile_favor_title'));
	}
	
	function delete($id)
	{
		if (!$id || !intval($id))
		{
			redirect(base_url().'my/favorites');
			die;
		}
		
		if ($this->pModel->checkFavorite($this->selfId, $id) != false)
		{
			$this->pModel->deleteFavorite($this->selfId, $id);
			redirect(base_url().'my/favorites');
		}
	}
}