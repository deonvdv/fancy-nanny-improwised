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
	public function index($page = 1, $itemsPerPage = 20)
	{
		try
		{
			$message      = array();
			$page         = (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 20 : $itemsPerPage;
			$skip         = ($page-1)*$itemsPerPage;

	        $collection = \Models\Message::skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Message::count();
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
        return View::make('messages.create');
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
			$message = new \Models\Message;
			$input = Input::all();

			foreach($message->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$message->$field = $input[$field];
				}
			}

			if ( $message->validate() ) {
				$message->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $message->toArray(),
						'message'	=> 'New Message created sucessfully!'
					),
					201
				);

				$response->header('Location', '/message/'.$message->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $message->errors()->toArray(),
						'message'	=> 'Error adding Message!'
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
					'data'		=> $message->toArray(),
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
			$message = \Models\Message::find($id);
			if(count($message) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $message->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Message with id: '.$id
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
		try
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

				if($message->validate()){
					$message->save();
					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $message->toArray(),
							'message'	=> 'Message updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $message->errors()->toArray(),
							'message'	=> 'Error updating Message!'
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
						'message'	=> 'Could not find Message with id: '.$id
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
			$message = \Models\Message::find($id);

			if(!is_null($message))
			{
				$status = $message->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $message->toArray(),
						'message'	=> ($status) ? 'Message deleted successfully!' : 'Error occured while deleting User'
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Message with id: '.$id
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

	public function unread($id, $page = 1)
	{
		try
		{
				$message 	= array();
				$page 		= (int) $page < 1 ? 1 : $page;
				$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
				$skip 		= ($page-1)*$itemPerPage;

				if ( \Models\Message::where('receiver_id','=',$id) ) 
				{
			        $collection = \Models\Message::where('receiver_id','=',$id)->with('sender')->unread()->take($itemPerPage)->get();
					$itemCount	= \Models\Message::where('receiver_id','=',$id)->with('sender')->unread()->count();
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
				} 
				else 
				{
		        	return parent::buildJsonResponse(
		        		array(
		        			'success'	=> false,
		        			'data'		=> null,
							'message'	=> 'Could not find Messages for user with id:'.$id
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


	public function received($id, $page = 1)
	{
		try
		{
				$message 	= array();
				$page 		= (int) $page < 1 ? 1 : $page;
				$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
				$skip 		= ($page-1)*$itemPerPage;

				if ( \Models\Message::where('receiver_id','=',$id) ) 
				{
			        $collection = \Models\Message::where('receiver_id','=',$id)->with('sender')->take($itemPerPage)->get();
					$itemCount	= \Models\Message::where('receiver_id','=',$id)->with('sender')->count();
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
				} 
				else 
				{
		        	return parent::buildJsonResponse(
		        		array(
		        			'success'	=> false,
		        			'data'		=> null,
							'message'	=> 'Could not find Messages for user with id:'.$id
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

	public function sent($id, $page = 1)
	{
		try
		{
				$message 	= array();
				$page 		= (int) $page < 1 ? 1 : $page;
				$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
				$skip 		= ($page-1)*$itemPerPage;

				if ( \Models\Message::where('sender_id','=',$id) ) 
				{
			        $collection = \Models\Message::where('sender_id','=',$id)->with('receiver')->take($itemPerPage)->get();
					$itemCount	= \Models\Message::where('sender_id','=',$id)->with('receiver')->count();
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
				} 
				else 
				{
		        	return parent::buildJsonResponse(
		        		array(
		        			'success'	=> false,
		        			'data'		=> null,
							'message'	=> 'Could not find Messages for user with id:'.$id
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
	 * setstatus read/unread the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function setstatus($id)
	{
		try
		{
			$message = \Models\Message::find($id);
			$status = Input::get('is_read');
			
			if(!is_null($message) && !is_null($status))
			{

				$message->is_read = $status;

				if ( $message->validate() ) {
				$message->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $message->toArray(),
						'message'	=> 'Message status updated successfully!'
					),
					201
				);

				$response->header('Location', '/message/'.$message->id);

				return $response;
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find todo with id: '.$id
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
