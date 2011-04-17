<?

class Model_Photo extends ORM {
	
	/**
	 * Keeps the user_id filter
	 */
	protected $_user_id = NULL;

	/**
	 * Sizes config
	 */
	protected $_sizes = array();
	
	/**
	 * Relations
	 */
	protected $_belongs_to = array(
		'user' => array(),
	);
 
 	public function __construct($id = NULL)
	{
		parent::__construct($id);

		$this->_sizes = Kohana::config('app.photo_sizes');
	}

 	/**
	 * Return photo object by filename
	 */
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

	/**
	 * Check if a user_id was set
	 */
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
		$this->resize_presets();

		return $this;
	}

	/**
	 * Resize photo for all preset sizes
	 */
	public function resize_presets()
	{
		if ( ! $this->loaded())
			return false;

		foreach ($this->_sizes as $name => $size)
		{
			$this->resize($size, $name);
		}

		return $this;
	}

	/**
	 * Resize to specific size
	 */
	private function resize(array $size, $name)
	{
		if ( ! $this->loaded())
			return false;

		// Check if destination dir exists, if not, create it
		$dir = dirname($this->get_full_path($name));
		if ( ! is_dir($dir))
		{
			if ( ! mkdir($dir))
				throw new Exception('Unable to create '.$dir.', check permissions.');
		}

		// Resize and save image
		$image = Image::factory($this->get_full_path());
		$image->resize($size[0], $size[1])
			->save($this->get_full_path($name));

		return $this;
	}

	/**
	 * Return full path on the filesystem from the original version
	 */
	public function get_full_path($version = 'original')
	{
		if ( ! $this->loaded())
			return false;

		$path = DOCROOT.Kohana::config('app.photo_path').'/'.$version.'/'.$this->filename;

		return $path;
	}

}

