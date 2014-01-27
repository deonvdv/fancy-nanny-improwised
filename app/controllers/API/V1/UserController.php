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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$users = \Models\User::find($id);
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
					'message'	=> 'Can not find Users ...'
				),
				404
			);
		}
        // return View::make('users.show');
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
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function picture($user_id)
	{
		$pictures = $this->pictures->getPictursByUser($user_id);
		$msg = json_decode($pictures);
		if(count($msg) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $pictures->toArray(),
					'message' => 'Pictures ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Pictures for User id : '.$user_id
				),
				404
			);
		}
	}

	public function recipes($user_id)
	{
		$notifications = $this->recipes->getRecipesByUser($user_id);
		$msg = json_decode($notifications);
		if(count($msg) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $notifications->toArray(),
					'message' => 'Notifications ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Notifications for User id : '.$user_id
				),
				404
			);
		}
		// return $user_id;
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
