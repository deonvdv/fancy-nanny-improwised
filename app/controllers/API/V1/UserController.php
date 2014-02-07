<?php
namespace API\V1;

use BaseController;
// use User;
use Response;
use Input;
// use View;
// use Recipe;
// use Picture;


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
	public function index($page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

        $collection = \Models\User::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\User::count();
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
        // return View::make('users.index');
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
		$user = new \Models\User;
		$input = Input::all();

		foreach($user->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$user->$field = $input[$field];
			}
		}

		try
		{
			$status = $user->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $user->toArray(),
					'message'	=> 'New User created sucessfully!'
				)
			);
		}
		catch(\Exception $ex)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $user->toArray(),
					'message'	=> $ex->getMessage()
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
			$users = \Models\User::where('id','=',$id)->firstOrFail();
			
			if(count($users) > 0)
			{
				return Response::json(
					array(
						'success' => true,
						'data'    => $users->toArray(),
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
						'message'	=> 'Can not find User with id '.$id
					),
					404
				);
			}
		}
		catch(\Exception $ex)
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
		//
		$user = \Models\User::find($id);
		$input = Input::all();
		if(!is_null($user))
		{
			foreach(\Models\User::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$user->$field = $input[$field];
				}
			}

			$status = $user->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $user->toArray(),
					'message'	=> 'User updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find User with id '.$id
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
		$user = \Models\User::find($id);

		if(!is_null($user))
		{
			$status = $user->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $user->toArray(),
					'message'	=> ($status) ? 'User deleted successfully!' : 'Error occured while deleting User'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find User with id '.$id
				),
				404
			);
		}
	}

	public function picture($id, $page = 1)
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
					'message'	=> 'Can not find Pictures for User id:'.$id
        		),
        		404
        	);
		}
	}

	public function recipes($id, $page = 1)
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
					'message'	=> 'Can not find Recipes for User id:'.$id
        		),
        		404
        	);
		}		
	}

	public function favorite_recipes($id, $page = 1)
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
					'message'	=> 'Can not find FavoriteRecipes for User id:'.$id
        		),
        		404
        	);
		}		
	}

	public function indexByHousehold($householdId = 0, $page = 1, $itemPerPage = 20)
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


}
