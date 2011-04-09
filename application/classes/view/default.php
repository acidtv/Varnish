<?

class View_Default extends Kostache_Layout {
 
 	public function flash()
	{
		$flash = Flash::factory()->render();
		return $flash;
	}
}

