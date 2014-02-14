<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class PictureController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($page = 1, $itemsPerPage = 20)
	{
		try
		{
			$message      = array();
			$page         = (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 20 : $itemsPerPage;
			$skip         = ($page-1)*$itemsPerPage;

	        $collection = \Models\Picture::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Picture::count();
			$totalPage 	= ceil($itemCount/$itemsPerPage);

			if($collection->isEmpty()) {
				$message[] = 'No records found in this collection.';
			}

	        return parent::buildJsonResponse(
	        	array(
	        		'success'		=> true,
	        		'page'			=> (int) $page,
	        		'items_per_page'	=> (int) $itemsPerPage,
	        		'total_item'	=> (int) $itemCount,
	        		'total_page'	=> (int) $totalPage,
	        		'data'			=> $collection->toArray(),
	        		'message'		=> implode($message, "\n")
	        	)
	        );
		}
		catch(\Exception $ex)
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'There was an error while processing your request: ' . $ex->getMessage()
				),
				500
			);
		}		
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('pictures.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	
	public function store()
	{
		try
		{
			$picture = new \Models\Picture;
			$input = Input::all();

			foreach($picture->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$picture->$field = $input[$field];
				}
			}

			if ( $picture->validate() ) {
				$picture->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $picture->toArray(),
						'message'	=> 'New Picture created sucessfully!'
					),
					201
				);

				$response->header('Location', '/picture/'.$picture->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $picture->errors()->toArray(),
						'message'	=> 'Error adding Picture!'
					),
					400
				);
			}
		}
		catch(\Exception $ex)
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> $picture->toArray(),
					'message'	=> 'There was an error while processing your request: ' . $ex->getMessage()
				),
				500
			);
		}
	}	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try {
			$picture = \Models\Picture::find($id);
			if(count($picture) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $picture->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Picture with id: '.$id
					),
					404
				);
			}
		}
		catch(\Exception $ex)
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'There was an error while processing your request: ' . $ex->getMessage()
				),
				500
			);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('pictures.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$pictures = \Models\Picture::find($id);
		$input = Input::all();

		if(!is_null($pictures))
		{
			foreach(\Models\Picture::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$pictures->$field = $input[$field];
				}
			}

			$status = $pictures->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $pictures->toArray(),
					'message'	=> 'Picture updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Picture with id: '.$id
				),
				404
			);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$pictures = \Models\Picture::find($id);

		if(!is_null($pictures))
		{
			$status = $pictures->delete();
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $pictures->toArray(),
					'message'	=> ($status) ? 'Picture deleted successfully!' : 'Error occured while deleting Picture'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Picture with id: '.$id
				),
				404
			);
		}
	}

}
