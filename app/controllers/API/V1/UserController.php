<?php
namespace API\V1;

use BaseController;
// use User;
use Response;
use Input;
// use View;
// use Recipe;
// use Picture;
use Hash;

class UserController extends BaseController {

	// /**
 //     * Recipe Model
 //     * @var Recipe
 //     */
 //    protected $recipes;

 //    /**
 //     * Picture Model
 //     * @var Picture
 //     */
 //    protected $pictures;
 //    public function __construct(Recipe $recipes, Picture $pictures)
 //    {
 //    	$this->recipes = $recipes;
 //    	$this->pictures = $pictures;
 //    }

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

	        $collection = \Models\User::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\User::count();
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
        return View::make('users.create');
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
			$user = new \Models\User;
			$input = Input::all();

			foreach($user->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$user->$field = $input[$field];
				}
			}

			if ( $user->validate() ) {
				$user->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $user->toArray(),
						'message'	=> 'New User created sucessfully!'
					),
					201
				);

				$response->header('Location', '/user/'.$user->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $user->errors()->toArray(),
						'message'	=> 'Error adding User!'
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
					'data'		=> $user->toArray(),
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
			$user = \Models\User::find($id);
			
			if(count($user) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $user->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find User with id: '.$id
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
        return View::make('users.edit');
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
			$user = \Models\User::find($id);
			$input = Input::all();
			if(!is_null($user))
			{
				foreach(\Models\User::fields() as $field)
				{
					if(isset($input[$field]))
					{
						if($field == 'password'){
							$user->$field = Hash::make($input[$field]);
						} else {
							$user->$field = $input[$field];
						}
					}
				}

				if ( $user->validate() ) {
					$user->save();

					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $user->toArray(),
							'message'	=> 'User updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $user->errors()->toArray(),
							'message'	=> 'Error updating User!'
						),
						400
					);
				}				
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find User with id: '.$id
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
			$user = \Models\User::find($id);

			if(!is_null($user))
			{
				$status = $user->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $user->toArray(),
						'message'	=> ($status) ? 'User deleted successfully!' : 'Error occured while deleting Category'
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find User with id: '.$id
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

	public function picture($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\User::find($id) ) {
		        $collection = \Models\User::find($id)->pictures()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\User::find($id)->pictures()->count();
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
						'message'	=> 'Could not find Pictures for User id:'.$id
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

			if ( \Models\User::find($id) ) {
		        $collection = \Models\User::find($id)->tags()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\User::find($id)->tags()->count();
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
						'message'	=> 'Could not find Tags for User id:'.$id
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

	public function recipes($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\User::find($id) ) {
		        $collection = \Models\User::find($id)->recipes()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\User::find($id)->recipes()->count();
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
						'message'	=> 'Could not find Recipes for User id:'.$id
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

	public function favorite_recipes($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\User::find($id) ) {
		        $collection = \Models\User::find($id)->favoriterecipes()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\User::find($id)->favoriterecipes()->count();
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
						'message'	=> 'Could not find FavoriteRecipes for User id:'.$id
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

	public function upcoming_events($id, $page = 1, $itemsPerPage = 5)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 5 : $itemsPerPage;
			$skip 		= ($page-1)*$itemsPerPage;

			if ( \Models\User::find($id) ) {
		        $collection = \Models\User::find($id)->upcoming_events()->skip($skip)->take($itemsPerPage)->get();
				$itemCount	= \Models\User::find($id)->upcoming_events()->count();
				$totalPage 	= ceil($itemCount/$itemsPerPage);

				if($collection->isEmpty()){
					$message[] = 'No records found in this collection.';
				}

		        return parent::buildJsonResponse(
		        	array(
		        		'success'		=> true,
		        		'page'			=> (int) $page,
		        		'item_per_page'	=> (int) $itemsPerPage,
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
						'message'	=> 'Could not find UpcomingEvents for User id:'.$id
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

	public function indexByHousehold($householdId = 0, $page = 1, $itemPerPage = 20)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$skip 		= ($page-1)*$itemPerPage;

	        $collection = User::skip($skip)->take($itemPerPage)->where('household_id', '=', $householdId)->get();
			$itemCount	= User::where('household_id', '=', $householdId)->count();
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

