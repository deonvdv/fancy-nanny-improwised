<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class MessageController extends BaseController {

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

        $collection = \Models\Message::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Message::count();
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
        // return View::make('messages.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('messages.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$message = new \Models\User;
		$input = Input::all();

		foreach($message->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$message->$field = $input[$field];
			}
		}

		try
		{
			$status = $message->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $message->toArray(),
					'message'	=> 'New Message created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $message->toArray(),
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
		$messages = \Models\Message::find($id);
		if(count($messages) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $messages->toArray(),
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
					'message'	=> 'Can not find Messages ...'
				),
				404
			);
		}
        // return View::make('messages.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('messages.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$message = \Models\Message::find($id);
		$input = Input::all();
		if(!is_null($message))
		{
			foreach(\Models\Message::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$message->$field = $input[$field];
				}
			}

			$status = $message->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $message->toArray(),
					'message'	=> 'Messages updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Message with id '.$id
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
		$message = \Models\Message::find($id);

		if(!is_null($message))
		{
			$status = $message->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $message->toArray(),
					'message'	=> ($status) ? 'Message deleted successfully!' : 'Error occured while deleting User'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Message with id '.$id
				),
				404
			);
		}
	}

}
