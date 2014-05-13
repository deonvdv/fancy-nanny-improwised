<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class TagController extends BaseController {

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

	        $collection = \Models\Tag::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Tag::count();
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
        return View::make('tags.create');
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
			$tag = new \Models\Tag;
			$input = Input::all();

			foreach($tag->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$tag->$field = $input[$field];
				}
			}

			if ( $tag->validate() ) {
				$tag->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $tag->toArray(),
						'message'	=> 'New Tag created sucessfully!'
					),
					201
				);

				$response->header('Location', '/tag/'.$tag->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $tag->errors()->toArray(),
						'message'	=> 'Error adding Todo!'
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
					'data'		=> $tag->toArray(),
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
		try
		{
			$tag = \Models\Tag::find($id);
			if(count($tag) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $tag->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Tag with id: '.$id,
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
        return View::make('tags.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try
		{
			$tag = \Models\Tag::find($id);
			$input = Input::all();

			if(!is_null($tag))
			{
				foreach(\Models\Tag::fields() as $field)
				{
					if(isset($input[$field])) {
						$tag->$field = $input[$field];
					}
				}

				if($tag->validate()) {
					$tag->save();

					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $tag->toArray(),
							'message'	=> 'Tag updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $tag->errors()->toArray(),
							'message'	=> 'Error updating Tag!'
						)
					);
				}
				
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Tag with id: '.$id
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
			$tag = \Models\Tag::find($id);

			if(!is_null($tag))
			{
				$status = $tag->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $tag->toArray(),
						'message'	=> ($status) ? 'Tag deleted successfully!' : 'Error occured while deleting Tag'
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Tag with id: '.$id
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

}
