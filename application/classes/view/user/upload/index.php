<?

class View_User_Upload_Index extends View_Default {
 
 	public function size_limit_bytes()
	{
		return Num::bytes($this->size_limit);
	}
}

