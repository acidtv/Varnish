<?

class View_User_Default extends View_Default {
 
	public function uri()
	{
		var_dump($this->request->uri(array('controller' => 'upload')));
		var_dump($this->request->uri(array('controller' => 'photos', 'id' => 234)));

		return array(
			'home' => '/'.$this->request->param('user'),
			'upload' => '/'.$this->request->param('user').'/upload',
			'dashboard' => '/'.$this->request->param('user'),
			);
	}

	public function render()
	{
		// Wrap user/* pages in user layout
		$this->_partials['content_user'] = $this->_template;
		$this->_template = $this->_load('user/layout');
		
		return parent::render();
	}
}

