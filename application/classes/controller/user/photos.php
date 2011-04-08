<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User_Photos extends Controller_Template {

	public function action_index($id)
	{
		//throw new HTTP_Exception_404(__('User does not exist.'));

		$photo = ORM::factory('photo', $id);

		$view = View::factory('pages/user/photo');

		$this->template->title = '$user $photo';	
		$this->template->content = $view;
	}

}
