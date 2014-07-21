<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class EventController extends BaseController {

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

	        $collection = \Models\Event::with(array('tags','owner'))->orderBy('title')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Event::count();
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
		catch(\Exception $e)
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
        return View::make('events.create');
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
			$event = new \Models\Event;
			$input = Input::all();

			foreach($event->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$event->$field = $input[$field];
				}
			}

			if ( $event->validate() ) {
				$event->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $event->toArray(),
						'message'	=> 'New Event created sucessfully!'
					),
					201
				);

				$response->header('Location', '/event/'.$event->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $event->errors()->toArray(),
						'message'	=> 'Error adding Event!'
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
					'data'		=> $document->toArray(),
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
			$event = \Models\Event::with(array('tags','owner'))->find($id);
			if(count($event) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $event->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Event with id: '.$id
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
        return View::make('events.edit');
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
			$event = \Models\Event::find($id);
			$input = Input::all();

			if(!is_null($event))
			{
				foreach(\Models\Event::fields() as $field)
				{
					if(isset($input[$field]))
					{
						$event->$field = $input[$field];
					}
				}

				if( $event->validate()) {
					$event->save();
					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $event->toArray(),
							'message'	=> 'Event updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $event->errors()->toArray(),
							'message'	=> 'Error updating Event!'
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
						'message'	=> 'Could not find Event with id: '.$id
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function addtag($id)
	{
		try
		{

			$event = \Models\Event::find($id);
			$tag = \Models\Tag::find( Input::get('tag_id') );
			$input = Input::all();

			if(!is_null($event) && !is_null($tag))
			{

				$event->addTag( $tag );

				return parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $event->toArray(),
						'message'	=> 'Tag Added sucessfully!'
					)
				);

			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Event with id: '.$id
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
	 * RemoveTag the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function removetag($id)
	{
		try
		{
			$event = \Models\Event::find($id);
			$tag = \Models\Tag::find( Input::get('tag_id') );
			$input = Input::all();

			if(!is_null($event) && !is_null($tag))
			{
				$event->removeTag( $tag );

				return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $event->toArray(),
							'message'	=> 'Tag Removed sucessfully!'
						)
					);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Event with id: '.$id
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

	public function recipe_ingredients($recipe_id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Recipe::find($recipe_id) ) {
		        $collection = \Models\RecipeIngredient::where('recipe_id', '=', $recipe_id)->get();
				$itemCount	= $collection->count();
				$totalPage 	= ceil($itemCount/$itemPerPage);

				if($collection->isEmpty()){
					$message[] = 'No records found in this collection.';
				}

		        return parent::buildJsonResponse(
		        	array(
		        		'success'		=> true,
		        		'page'			=> (int) $page,
		        		'item_per_page'	=> (int) $itemPerPage,
		        		'total_item'	=> (int) $itemCount,
		        		'total_page'	=> (int) $totalPage,
		        		'data'			=> $collection->toArray(),
		        		'message'		=> implode($message, "\n")
		        	)
		        );
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find RecipeIngredients with recipe id :'.$recipe_id
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
			$event = \Models\Event::find($id);

			if(!is_null($event))
			{
				$status = $event->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $event->toArray(),
						'message'	=> ($status) ? 'Event deleted successfully!' : 'Error occured while deleting Event'
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Event with id: '.$id
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

	public function tags($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Event::find($id) ) {
		        $collection = \Models\Event::find($id)->tags()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\Event::find($id)->tags()->count();
				$totalPage 	= ceil($itemCount/$itemPerPage);

				if($collection->isEmpty()){
					$message[] = 'No records found in this collection.';
				}

		        return parent::buildJsonResponse(
		        	array(
		        		'success'		=> true,
		        		'page'			=> (int) $page,
		        		'item_per_page'	=> (int) $itemPerPage,
		        		'total_item'	=> (int) $itemCount,
		        		'total_page'	=> (int) $totalPage,
		        		'data'			=> $collection->toArray(),
		        		'message'		=> implode($message, "\n")
		        	)
		        );
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find Event Tags Event id:'.$id
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

	public function attendees($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Event::find($id) ) {
		        $collection = \Models\Event::find($id)->attendees()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\Event::find($id)->attendees()->count();
				$totalPage 	= ceil($itemCount/$itemPerPage);

				if($collection->isEmpty()){
					$message[] = 'No records found in this collection.';
				}

		        return parent::buildJsonResponse(
		        	array(
		        		'success'		=> true,
		        		'page'			=> (int) $page,
		        		'item_per_page'	=> (int) $itemPerPage,
		        		'total_item'	=> (int) $itemCount,
		        		'total_page'	=> (int) $totalPage,
		        		'data'			=> $collection->toArray(),
		        		'message'		=> implode($message, "\n")
		        	)
		        );
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find Event Tags Event id:'.$id
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
