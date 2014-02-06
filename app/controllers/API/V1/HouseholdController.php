<?php
namespace API\V1;

// use \Models;
use BaseController;
use Response;
use Input;
use View;

class HouseholdController extends BaseController {

	public function __construct( )
    {
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Response::json
	 */
	public function index($page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

        $collection = \Models\Household::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Household::count();
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
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('housholds.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$household = new \Models\Household;
		$input = Input::all();

		foreach($household->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$household->$field = $input[$field];
			}
		}

		try
		{
			$status = $household->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $household->toArray(),
					'message'	=> 'New Household created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $household->toArray(),
					'message'	=> $e->getMessage()
				),
				500
			);
		}

	}

	/**
	 * Display the specified resource.
	 *
	 * Includes Members
	 * Includes Documents (limited to 20 records)
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try
		{
			$household = \Models\Household::with(array('documents','events','members'))->find($id);

	        if(!is_null($household))
	        {
	        	return Response::json(
	        		array(
	        			'success'	=> true,
	        			'data'		=> $household->toArray(),
	        			'message'	=> 'success..'
	        		)
	        	);
	        }
	        else
	        {
	        	return Response::json(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Can not find Household with id:'.$id
	        		),
	        		404
	        	);
	        }
		}
		catch(\Exception $e)
		{
			return Response::json(
        		array(
        			'success'	=> false,
        			'data'		=> null,
					'message'	=> 'There is some error to process your request'
        		),
        		404
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
        return View::make('housholds.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$household = \Models\Household::find($id);
		$input = Input::all();

		if(!is_null($household))
		{
			foreach(\Models\Household::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$household->$field = $input[$field];
				}
			}

			$status = $household->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $household->toArray(),
					'message'	=> 'Household updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Household with id '.$id
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
		$household = \Models\Household::find($id);

		if(!is_null($household))
		{
			$status = $household->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $household->toArray(),
					'message'	=> ($status) ? 'Household deleted successfully!' : 'Error occured while deleting Household'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Household with id '.$id
				),
				404
			);
		}
	}

	public function documents($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->documents()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->documents()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

	public function messages($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->messages()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->messages()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

	public function tags($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->tags()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->tags()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

	public function members($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->members()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->members()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

	public function meals($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->tags()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->tags()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

	public function events($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->events()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->events()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

	public function todos($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->todos()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->todos()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

	public function notifications($householdId, $page = 1){
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\Household::find($householdId) ) {
	        $collection = \Models\Household::find($householdId)->notifications()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Household::find($householdId)->notifications()->count();
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
					'message'	=> 'Can not find Household with id '.$householdId
        		),
        		404
        	);
		}
	}

}
