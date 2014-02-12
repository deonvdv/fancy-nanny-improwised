<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class TodoController extends BaseController {

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

        $collection = \Models\Todo::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Todo::count();
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
        // return View::make('todos.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('todos.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$todos = new \Models\Todo;
		$input = Input::all();

		foreach($todos->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$todos->$field = $input[$field];
			}
		}

		try
		{
			$status = $todos->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $todos->toArray(),
					'message'	=> 'New Todo created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> $todos->toArray(),
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
		try {
			$todo = \Models\Todo::find($id);
			if(count($todo) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $todo->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Todo with id: '.$id
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
        return View::make('todos.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$todos = \Models\Todo::find($id);
		$input = Input::all();

		if(!is_null($todos))
		{
			foreach(\Models\Todo::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$todos->$field = $input[$field];
				}
			}

			$status = $todos->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $todos->toArray(),
					'message'	=> 'Todo updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Todo with id: '.$id
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
		$todos = \Models\Todo::find($id);

		if(!is_null($todos))
		{
			$status = $todos->delete();
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $todos->toArray(),
					'message'	=> ($status) ? 'Todo deleted successfully!' : 'Error occured while deleting Todo'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Todo with id: '.$id
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

		if ( \Models\Todo::find($id) ) {
	        $collection = \Models\Todo::find($id)->tags()->skip($skip)->take($itemPerPage)->get();
			$itemCount	= \Models\Todo::find($id)->tags()->count();
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
					'message'	=> 'Could not find Tags for Todo id:'.$id
        		),
        		404
        	);
		}
	}

}
