<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Default extends Controller_Default {

	/**
	 * Contains the user object that belongs to the page being viewed
	 */
	var $_page_owner = null;

	/**
	 * TRUE if current page is the user's own page
	 */
	var $_own_page = FALSE;

	/**
	 * Does some stuff before loading any of the user specific pages
	 */
	public function before()
	{
		parent::before();

		$username = $this->request->param('user');

		// Check if url contained a <user> param
		if ( ! $username)
			throw new HTTP_Exception_404();

		$user = Model_User::get_by_username($username);

		// Check if user exists, throw 404 if not
		if ( ! $user)
			throw new HTTP_Exception_404();

		$this->_page_owner = $user;

		// Check if this page is the user's own page
		if (is_object($this->_visitor) AND $this->_visitor->id == $this->_page_owner->id)
		{
			$this->_own_page = TRUE;
		}
	}
	
	public function after()
	{
		// Render template
		if (is_object($this->_view))
		{
			$this->_view->set('page_owner', $this->_page_owner);
		}

		parent::after();
	}

}
