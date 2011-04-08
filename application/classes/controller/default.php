<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Default extends Controller {

	protected $_view = null;

	/**
	 * Contains the visitors user object (if logged in)
	 */
	var $_visitor = null;

	public function before()
	{
		parent::before();

		// Get logged in user
		$this->_visitor = Auth::instance()->get_user();

		// Automagically create a new view object
		$view = 'View_'.($this->request->directory()?$this->request->directory().'_':'').$this->request->controller().'_'.$this->request->action();

		if (class_exists($view))
		{
			$this->_view = new $view;
		}
	}

	public function after()
	{
		// Render template
		if (is_object($this->_view))
		{
			$this->_view->set('visitor', $this->_visitor);
			$this->response->body((string)$this->_view);
		}
	}

}
