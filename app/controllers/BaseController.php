<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	protected function buildJsonResponse($content = array(), $HTTPStatusCode = 200) {
		$content["meta"] = $this->buildMeta();
		return Response::json( $content, $HTTPStatusCode );
	}

	protected function buildMeta() {
		$meta = array();
		$meta["uri"] = Request::path();
		return $meta;
	}
}