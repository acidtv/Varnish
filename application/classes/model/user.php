<?

class Model_User extends Model_Auth_User {
 
 	protected $_has_many = array(
		'photos' => array(),
		'user_tokens' => array('model' => 'user_token'),
		'roles'       => array('model' => 'role', 'through' => 'roles_users'),
	);


	/**
	 * Return new user object by username
	 */
	static function get_by_username($username)
	{
		$users = ORM::factory('user')->where('username', '=', $username)->find_all()->as_array();
		$user = Arr::get($users,0);
		return $user;
	}

	/**
	 * Return last photos in stream
	 */
	public function get_photostream()
	{
		return ORM::factory('photo')
			->set_user_id($this->id)
			->get_photostream();
	}

	/**
	 * Login user
	 */
	public function login($username, $password)
	{
		$result = Auth::instance()->login($username, $password, TRUE);
		var_dump($result);
		return $result;
	}

	/**
	 * Create user and add login role to user
	 */
	public function create_user($values, $expected)
	{
		$return = parent::create_user($values, $expected);

		$this->add('roles', ORM::factory('role', 1));

		return $return;
	}
}

