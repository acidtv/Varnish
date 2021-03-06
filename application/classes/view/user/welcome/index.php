<?

class View_User_Welcome_Index extends View_User_Default {
 
 	public function username()
	{
		return $this->page_owner->username;
	}

	public function photostream()
	{
		$photos = $this->page_owner->get_photostream();

		foreach ($photos as &$photo)
		{
			$photo = $photo->as_array();
			$photo['url'] = $this->request->uri(array('controller' => 'photos', 'id' => $photo['id']));
		}

		return $photos;
	}

}

