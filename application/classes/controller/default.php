<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Default extends Controller {

	/**
	 * Controls if view is autorendered or not
	 */
	protected $auto_render = TRUE;

	/**
	 * Controls authentication for the whole controller.
	 * Examples:
	 * $auth_required = 'login'; // require login role for all actions
	 * $auth_required = array('login','admin'); // require login AND admin role for all actions
	 */
	protected $auth_required = FALSE;

	/**
	 * Controls authentication per action.
	 * Examples:
	 * $secure_actions =  array('index' => array('login')); // require login role for action_index
	 * $secure_actions = array('edit' => array('login', 'admin')); // require login AND admin role for action_edit
	 */
	protected $secure_actions = FALSE;

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

		$auth = Auth::instance();
		$action = $this->request->action();

		// Get logged in user
		$this->_visitor = $auth->get_user();

		// Check if user has access to this action
		if (($this->auth_required !== FALSE AND $auth->logged_in($this->auth_required) === FALSE) OR
			(is_array($this->secure_actions) AND array_key_exists($action, $this->secure_actions) AND $auth->logged_in($this->secure_actions[$action]) === FALSE))
		{
			throw new Exception('Access denied');
		}

		// Automagically create a new view object
		if ($this->auto_render)
		{
			$view = 'View_'.($this->request->directory()?$this->request->directory().'_':'').$this->request->controller().'_'.$action;

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
