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
	public function index($page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

        $collection = \Models\Event::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Event::count();
		$totalPage 	= ceil($itemCount/$itemPerPage);

		if($collection->isEmpty()){
			$message[] = 'No records found in this collection.';
		}

        return Response::json(
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
        // return View::make('events.index');
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
		$events = new \Models\Event;
		$input = Input::all();

		foreach($events->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$events->$field = $input[$field];
			}
		}

		try
		{
			$status = $events->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $events->toArray(),
					'message'	=> 'New Event created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $events->toArray(),
					'message'	=> $e->getMessage()
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
		$events = \Models\Event::find($id);
		if(count($events) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $events->toArray(),
					'message' => 'Success ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Events ...'
				),
				404
			);
		}
        // return View::make('events.show');
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

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $events->toArray(),
					'message'	=> 'Event updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Event with id '.$id
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
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $events->toArray(),
					'message'	=> ($status) ? 'Event deleted successfully!' : 'Error occured while deleting Event'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Event with id '.$id
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

	        return Response::json(
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
        	return Response::json(
        		array(
        			'success'	=> false,
        			'data'		=> null,
					'message'	=> 'Can not find Event Tags Event id:'.$id
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

	        return Response::json(
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
        	return Response::json(
        		array(
        			'success'	=> false,
        			'data'		=> null,
					'message'	=> 'Can not find Event Tags Event id:'.$id
        		),
        		404
        	);
		}
	}

}
