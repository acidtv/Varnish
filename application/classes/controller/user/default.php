<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Default extends Controller_Default {

	/**
	 * Contains the user object that belongs to the page being viewed
	 */
	protected $_page_owner = null;

	/**
	 * TRUE if current page is the user's own page
	 */
	protected $_own_page = FALSE;

	/**
	 * If set to TRUE, requires that this is $_visitor's own page
	 */
	protected $_own_page_required = FALSE;

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

		// Check if this page is only accessible to the page owner
		if ($this->_own_page_required AND ! $this->_own_page)
		{
			throw new Exception('Access denied');
		}
	}
	
	public function after()
	{
		// Render template
		if (is_object($this->_view))
		{
			$this->_view->set('own_page', $this->_own_page);
			$this->_view->set('page_owner', $this->_page_owner);
		}

		parent::after();
	}

}
