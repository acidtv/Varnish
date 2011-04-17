<?

class Route extends Kohana_Route {

	/**
	 * Filter the /index part out of generated uri
	 * FIXME: find better way to do this...
	 */
	public function uri(array $params = NULL)
	{
		$uri = parent::uri($params);
		$uri = str_replace('/index', '', $uri);
		return $uri;
	}
 
}

