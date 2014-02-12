<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class NotificationController extends BaseController {

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

        $collection = \Models\Notification::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Notification::count();
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
        // return View::make('notifications.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('notifications.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$notifications = new \Models\Notification;
		$input = Input::all();

		foreach($notifications->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$notifications->$field = $input[$field];
			}
		}

		try
		{
			$status = $notifications->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $notifications->toArray(),
					'message'	=> 'New Notification created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> $notifications->toArray(),
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
			$notification = \Models\Notification::find($id);
			if(count($notification) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $notification->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Notification with id: '.$id
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
        return View::make('notifications.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$notifications = \Models\Notification::find($id);
		$input = Input::all();

		if(!is_null($notifications))
		{
			foreach(\Models\Notification::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$notifications->$field = $input[$field];
				}
			}

			$status = $notifications->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $notifications->toArray(),
					'message'	=> 'Notification updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Notification with id: '.$id
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
		$notifications = \Models\Notification::find($id);

		if(!is_null($notifications))
		{
			$status = $notifications->delete();
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $notifications->toArray(),
					'message'	=> ($status) ? 'Notification deleted successfully!' : 'Error occured while deleting Notification'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Notification with id: '.$id
				),
				404
			);
		}
	}

}
