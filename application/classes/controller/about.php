<?php defined('SYSPATH') or die('No direct script access.');

class Controller_About extends Controller_Template {

	public function action_index()
	{
		$view = View::factory('pages/about');
		$this->template->title = 'About';	
		$this->template->content = $view;
	}

}
