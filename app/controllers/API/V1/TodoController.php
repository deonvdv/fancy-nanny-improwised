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
	public function index($page = 1, $itemsPerPage = 20)
	{
		try
		{
			$message      = array();
			$page         = (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 20 : $itemsPerPage;
			$skip         = ($page-1)*$itemsPerPage;

	        $collection = \Models\Todo::with(array('tags'))->orderBy('title')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Todo::count();
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
        return View::make('todos.create');
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
			$todo = new \Models\Todo;
			$input = Input::all();

			foreach($todo->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$todo->$field = $input[$field];
				}
			}

			if ( $todo->validate() ) {
				$todo->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $todo->toArray(),
						'message'	=> 'New Todo created sucessfully!'
					),
					201
				);

				$response->header('Location', '/todo/'.$todo->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $todo->errors()->toArray(),
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
					'data'		=> $todo->toArray(),
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
			$todo = \Models\Todo::with(array('tags'))->find($id);
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
		try
		{
			$todo = \Models\Todo::find($id);
			$input = Input::all();

			if(!is_null($todo))
			{
				foreach(\Models\Todo::fields() as $field)
				{
					if(isset($input[$field]))
					{
						$todo->$field = $input[$field];
					}
				}

				if($todo->validate()){
					$todo->save();
						return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $todo->toArray(),
							'message'	=> 'Todo updated sucessfully!'
						)
					);	
				}
				else
				{
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $todo->errors()->toArray(),
							'message'	=> 'Error updating Todo!'
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function addtag($id)
	{
		try
		{

			$todo = \Models\Todo::find($id);
			$tag = \Models\Tag::find( Input::get('tag_id') );
			$input = Input::all();

			if(!is_null($todo) && !is_null($tag))
			{

				$todo->addTag( $tag );

					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $todo->toArray(),
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
			$todo = \Models\Todo::find($id);
			$tag = \Models\Tag::find( Input::get('tag_id') );
			$input = Input::all();

			if(!is_null($todo) && !is_null($tag))
			{
				$todo->removeTag( $tag );

				return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $todo->toArray(),
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
			$todo = \Models\Todo::find($id);
			$status = Input::get('is_complete');
			
			if(!is_null($todo) && !is_null($status))
			{

				$todo->is_complete = $status;

				if ( $todo->validate() ) {
				$todo->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $todo->toArray(),
						'message'	=> 'Todo status updated successfully!'
					),
					201
				);

				$response->header('Location', '/todo/'.$todo->id);

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
			$todo = \Models\Todo::find($id);

			if(!is_null($todo))
			{
				$status = $todo->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $todo->toArray(),
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

	public function assigned($id, $page = 1)
	{
		try
		{
				$message 	= array();
				$page 		= (int) $page < 1 ? 1 : $page;
				$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
				$skip 		= ($page-1)*$itemPerPage;

				if ( \Models\Todo::where('assigned_to','=',$id) ) 
				{
			        $collection = \Models\Todo::with(array('tags'))->where('assigned_to','=',$id)->with('assigned_by','assigned_to')->remaining()->take($itemPerPage)->get();
					$itemCount	= \Models\Todo::where('assigned_to','=',$id)->remaining()->count();
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
							'message'	=> 'Could not find Todo for user with id:'.$id
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

	public function completed($id, $page = 1)
	{
		try
		{
				$message 	= array();
				$page 		= (int) $page < 1 ? 1 : $page;
				$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
				$skip 		= ($page-1)*$itemPerPage;

				if ( \Models\Todo::where('assigned_to','=',$id) ) 
				{
			        $collection = \Models\Todo::with(array('tags'))->where('assigned_to','=',$id)->with('assigned_by','assigned_to')->completed()->take($itemPerPage)->get();
					$itemCount	= \Models\Todo::where('assigned_to','=',$id)->completed()->count();
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
							'message'	=> 'Could not find Todo for user with id:'.$id
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

	public function assignedto($id, $page = 1)
	{
		try
		{
				$message 	= array();
				$page 		= (int) $page < 1 ? 1 : $page;
				$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
				$skip 		= ($page-1)*$itemPerPage;

				if ( \Models\Todo::where('assigned_to','=',$id) ) 
				{
			        $collection = \Models\Todo::with(array('tags'))->where('assigned_by','=',$id)->with('assigned_by','assigned_to')->take($itemPerPage)->get();
					$itemCount	= \Models\Todo::where('assigned_by','=',$id)->count();
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
							'message'	=> 'Could not find Todo for user with id:'.$id
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

				if ( \Models\Todo::find($id) ) 
				{
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
				} 
				else 
				{
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
