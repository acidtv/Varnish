<?

class View_User_Welcome_Index extends Kostache_Layout {
 
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
		}

		return $photos;
	}
}

