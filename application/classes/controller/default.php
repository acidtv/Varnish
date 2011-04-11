<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Default extends Controller {

	/**
	 * Controls if view is autorendered or not
	 */
	protected $auto_render = TRUE;

	/**
	 * Contains the view object that will be rendered in the after() method
	 */
	protected $_view = null;

	/**
	 * Contains the visitors user object (if logged in)
	 */
	protected $_visitor = null;

	/**
	 * Keeps javascript files
	 */
	protected $_scripts = array();

	/**
	 * Keeps css files
	 */
	protected $_styles = array();

	public function before()
	{
		parent::before();

		// Get logged in user
		$this->_visitor = Auth::instance()->get_user();

		// Automagically create a new view object
		if ($this->auto_render)
		{
			$view = 'View_'.($this->request->directory()?$this->request->directory().'_':'').$this->request->controller().'_'.$this->request->action();

			if (class_exists($view))
			{
				$this->_view = new $view;
			}
		}
	}

	public function after()
	{
		// Render template
		if ($this->auto_render AND is_object($this->_view))
		{
			$this->_scripts[] = '/media/js/jquery.min.js';
			$this->_styles[] = array('file' => '/media/css/default.css', 'media' => 'screen');

			$this->_view->set('scripts', $this->_scripts);
			$this->_view->set('styles', $this->_styles);
			$this->_view->set('visitor', $this->_visitor);

			$this->response->body((string)$this->_view);
		}
	}

}
