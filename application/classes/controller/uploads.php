<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Uploads extends Controller_Default {

	public function action_index($size, $filename)
	{
		$this->auto_render = FALSE;

		if ( ! $photo = Model_Photo::get_by_filename($filename))
			throw new HTTP_Exception_404('Image not found.');

		// FIXME check permissions

		// Generate ETag
		$etag = sha1($photo->filename.$photo->size.$photo->modify_date);

		// Check the ETag for this file.
		// If ETag matches browser tag, request will end here.
		$this->response->check_cache($etag, $this->request);

		$this->response->headers('ETag', $etag);

		$path = DOCROOT . 'uploads/'.$size.'/'.$photo->filename;

		$this->response->send_file($path, null, array('inline' => TRUE));
	}

}
