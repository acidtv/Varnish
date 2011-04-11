<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Default {

	public function action_index()
	{
		// Logout user
		if (Arr::get($_GET, 'logout'))
		{
			Auth::instance()->logout();
			Flash::factory()->add('You have been logged out.');
			$this->request->redirect('/');
		}

		// Redir if already logged in
		if(Auth::instance()->logged_in()!= 0)
		{
			$this->request->redirect('account/');		
		}
 
 		$err = false;

		// Perform login
		if ($_POST)
		{
			$user = ORM::factory('user');
			$status = $user->login($_POST['username'], $_POST['password']);
 
			if ($status)
			{		
				Flash::factory()->add('You have been logged in.');
				$this->request->redirect('/');
			}
			else
			{
				$err = true;
			}
		}

		$this->_view->set('err', $err);
	}

}
