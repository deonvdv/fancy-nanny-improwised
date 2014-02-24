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
	public function index($page = 1, $itemsPerPage = 20)
	{
		try
		{
			$message      = array();
			$page         = (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 20 : $itemsPerPage;
			$skip         = ($page-1)*$itemsPerPage;

	        $collection = \Models\Notification::orderBy('message')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Notification::count();
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
        return View::make('notifications.create');
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
			$notification = new \Models\Notification;
			$input = Input::all();

			foreach($notification->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$notification->$field = $input[$field];
				}
			}

			if ( $notification->validate() ) {
				$notification->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $notification->toArray(),
						'message'	=> 'New Notification created sucessfully!'
					),
					201
				);

				$response->header('Location', '/notification/'.$notification->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $notification->errors()->toArray(),
						'message'	=> 'Error adding Notification!'
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
					'data'		=> $notification->toArray(),
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
		try
		{
			$notification = \Models\Notification::find($id);
			$input = Input::all();

			if(!is_null($notification))
			{
				foreach(\Models\Notification::fields() as $field)
				{
					if(isset($input[$field]))
					{
						$notification->$field = $input[$field];
					}
				}

				if($notification->validate()){
					$notification->save();
					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $notification->toArray(),
							'message'	=> 'Notification updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $notification->errors()->toArray(),
							'message'	=> 'Error updating Notification!'
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
			$notification = \Models\Notification::find($id);

			if(!is_null($notification))
			{
				$status = $notification->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $notification->toArray(),
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
