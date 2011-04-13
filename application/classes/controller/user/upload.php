<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Upload extends Controller_User_Default {

	protected $auth_required = 'login';

	protected $_own_page_required = TRUE;

	public function before()
	{
		if ($this->request->action() == 'receive')
		{
			// Set session id from $_REQUEST, because flash upload doesn't automatically use the session cookie
			Session::instance(NULL, Arr::get($_REQUEST,'session_id'));
		}

		parent::before();
	}

	/**
	 * Display upload page
	 */
	public function action_index()
	{
		$this->_view->set('size_limit', ini_get('upload_max_filesize'));
		$this->_view->set('allowed_extensions', '*.jpg;*.gif;*.png');

		// Add session id to page so flash uploads can preserve the session
		$this->_view->set('session_id', Session::instance()->id());
	}

	/**
	 * Receive file
	 */
	public function action_receive()
	{
		$this->auto_render = FALSE;

		// Save move temp. file to upload dir
		if (array_key_exists('Filedata', $_FILES) AND $file = Upload::save(Arr::get($_FILES,'Filedata'), null, 'uploads/original'))
		{
			// Add to user
			ORM::factory('photo')
				->set_user_id($this->_visitor->id)
				->add($file);

			$this->response->body('ok');
		}
		else
		{
			$this->response->body('upload failed');
		}
		

	}

}
