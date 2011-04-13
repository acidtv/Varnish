<?

class Model_Photo extends ORM {
	
	/**
	 * Keeps the user_id filter
	 */
	protected $_user_id = NULL;

	protected $_belongs_to = array(
		'user' => array(),
	);
 
 	public static function get_by_filename($filename)
	{
		$photos = ORM::factory('photo')->where('filename', '=', $filename)
			->find_all()->as_array();

		return Arr::get($photos, 0);
	}

 	/**
	 * Set the user_id filter
	 */
 	public function set_user_id($user_id)
	{
		$this->_user_id = $user_id;

		return $this;
	}

	private function check_user_id()
	{
		if ( ! $this->_user_id)
			throw new Exception('Specify a user_id');

		return $this;
	}

 	/**
	 * Return photostream for $user_id
	 */
	public function get_photostream()
	{
		$this->check_user_id();

		$photos = $this->where('user_id' , '=', $this->_user_id)
			->order_by('upload_date', 'desc')
			->find_all()->as_array();

		return $photos;
	}

	/**
	 * Add photo to user
	 */
	public function add($filename, $title = null, $description = null)
	{
		$this->check_user_id();

		if ( ! $filename)
			throw new Exception('Specify a filename');

		$values = array(
			'user_id' => $this->_user_id,
			'filename' => basename($filename),
			'title' => $title,
			'description' => $description,
			'upload_date' => date('c'),
			);

		$this->values($values);
		$this->save();

		return $this;
	}

}

