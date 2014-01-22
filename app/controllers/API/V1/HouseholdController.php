<?php
namespace API\V1;

use \Model\Household;
use \BaseController;
use \Response;
use \Input;
use \View;
use \Model\Meal;
use \Model\Message;
use \Model\Tag;
use \Model\Event;

class HouseholdController extends BaseController {

	/**
     * Message Model
     * @var Message
     */
    protected $messages;

    /**
     * Meal Model
     * @var Message
     */
	protected $meal;

	/**
     * Tag Model
     * @var Tag
     */
	protected $tags;

	/**
     * Tag Model
     * @var Tag
     */
	protected $events;

	public function __construct( Message $messages,Meal $meal, Tag $tags, Event $events)
    {
    	$this->messages = $messages;
        $this->meal = $meal;
        $this->tags = $tags;
        $this->events = $events;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Response::json
	 */
	public function index($page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

        $collection = Household::skip($skip)->take($itemPerPage)->get();
		$itemCount	= Household::count();
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('housholds.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$household = new Household;
		$input = Input::all();

		foreach($household->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$household->$field = $input[$field];
			}
		}

		try
		{
			$status = $household->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $household->toArray(),
					'message'	=> 'New Household created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $household->toArray(),
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
        $household = Household::find($id);

        if(!is_null($household))
        {
        	return Response::json(
        		array(
        			'success'	=> true,
        			'data'		=> $household->toArray(),
        			'message'	=> ''
        		)
        	);
        }
        else
        {
        	return Response::json(
        		array(
        			'success'	=> false,
        			'data'		=> null,
					'message'	=> 'Can not find Household with id '.$id
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
        return View::make('housholds.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$household = Household::find($id);
		$input = Input::all();

		if(!is_null($household))
		{
			foreach(Household::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$household->$field = $input[$field];
				}
			}

			$status = $household->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $household->toArray(),
					'message'	=> 'Household updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Household with id '.$id
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
		$household = Household::find($id);

		if(!is_null($household))
		{
			$status = $household->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $household->toArray(),
					'message'	=> ($status) ? 'Household deleted successfully!' : 'Error occured while deleting Household'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Household with id '.$id
				),
				404
			);
		}
	}

	public function messages($householdId){
		$messages = $this->messages->getMessagesByHouseholds($householdId);
		return $messages;
	}

	public function tags($householdId){
		$tags = $this->tags->getTagsByHouseholds($householdId);
		return $tags;
	}

	public function members($householdId){
		$userController = new UserController();
		return $userController->indexByHousehold($householdId);
	}

	public function meals($householdId){
		$meal = $this->meal->getMealsByHouseholds($householdId);
		return $meal;
	}

	public function events($householdId){
		$tags = $this->events->getEventsByHouseholdes($householdId);
		return $events;
	}

	public function todos($householdId){

	}

	public function notifications($householdId){
		
	}

}
