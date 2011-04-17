<?

class View_User_Photos_Index extends View_User_Default {
 
 	public function photo()
	{
		$photo = $this->photoobj->as_array();
		return $photo;
	}
}

