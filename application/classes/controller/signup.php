<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Signup extends Controller_Default {

	public function action_index()
	{
		if ($_POST)
		{
			$user = ORM::factory('user');
			$user->values($_POST);

			try 
			{
				$user->create_user($_POST, array(
					'username',
					'password',
					'email'));
			}
			catch (ORM_Validation_Exception $e)
			{
				print_r($e->errors());
			}
		}
	}

}
