<?

class Model_Photo extends ORM {
 
	public function get_photostream($user_id)
	{
		if ( ! $user_id)
			return false;

		$photos = $this->where('user_id' , '=', $user_id)
			->order_by('upload_date', 'desc')
			->find_all()->as_array();

		return $photos;
	}
}

