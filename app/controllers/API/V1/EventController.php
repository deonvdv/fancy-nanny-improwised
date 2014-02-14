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

	        $collection = \Models\Event::orderBy('title')->skip($skip)->take($itemsPerPage)->get();
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
						'data'		=> $category->toArray(),
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
		try {
			$event = \Models\Event::find($id);
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
		$events = \Models\Event::find($id);
		$input = Input::all();

		if(!is_null($events))
		{
			foreach(\Models\Event::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$events->$field = $input[$field];
				}
			}

			$status = $events->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $events->toArray(),
					'message'	=> 'Event updated sucessfully!'
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

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$events = \Models\Event::find($id);

		if(!is_null($events))
		{
			$status = $events->delete();
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $events->toArray(),
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

	public function tags($id, $page = 1){
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

	public function attendees($id, $page = 1){
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

}
