<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Photos extends Controller_User_Default {

	public function action_index($id)
	{
		$photo = ORM::factory('photo', $id);
		$this->_view->set('photo', $photo);
	}

}
