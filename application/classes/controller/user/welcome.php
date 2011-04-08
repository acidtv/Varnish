<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Welcome extends Controller_User_Default {

	/**
	 * Display user homepage
	 */
	public function action_index()
	{
		$this->_view->set('page_owner', $this->_page_owner);
	}

}
