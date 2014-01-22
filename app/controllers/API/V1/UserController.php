<?php
namespace API\V1;
use \BaseController;
use \User;
use \Response;
use \Input;
use \View;
use \Model\Recipe;

class UserController extends BaseController {

	/**
     * Message Model
     * @var Message
     */
    protected $recipes;
    public function __construct(Recipe $recipes)
    {
    	$this->recipes = $recipes;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return User::get();
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
		// return $id;
		return User::find($id);
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

	public function picture($id)
	{
		return $id;
	}

	public function recipes($user_id)
	{
		return $this->recipes->getRecipesByUser($user_id);
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
