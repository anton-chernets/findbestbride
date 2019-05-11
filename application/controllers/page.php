<?php


/***** Статические страницы *****/

Class Page extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function faq()
	{
		$this->layout('content', 'content/faq_view', array(), 'FAQ');
	}
	
	function romance_tours()
	{
		$this->layout('content', 'content/rt_view', array(), 'Romance tours');
	}
	
	function information($subpage = false)
	{
		if ($subpage == false)
		{
			$this->layout('content', 'content/info_main_view', array(), 'Useful information');
		}
		elseif ($subpage == '1')
		{
			$this->layout('content', 'content/billing_issues', array(), 'Billing Issues');
		}
		elseif ($subpage == '2')
		{
			$this->layout('content', 'content/refund_policy', array(), 'Refund policy');
		}
		elseif ($subpage == '3')
		{
			redirect(base_url() . 'page/romance_tours');
			return false;
		}
		elseif ($subpage == '4')
		{
			redirect(base_url() . 'page/faq/');
			return false;
		}
		elseif ($subpage == '5')
		{
			$this->layout('content', 'content/terms_of_use', array(), 'Terms of use');
		}
		elseif ($subpage == '6')
		{
			$this->layout('content', 'content/imbra_comp', array(), 'IMBRA Compiliance');
		}
		elseif ($subpage == 'find-love')
		{
			$this->layout('content', 'content/find_love', array(), 'Kiev, Dnepropetrovsk - Find Love In Ukraine');
		}
	}
}