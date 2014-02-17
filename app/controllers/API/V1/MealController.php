<?php
namespace API\V1;
use BaseController;
// use \Model\Meal;
// use \Model\MealRecipe;
// use \Model\MealTag;
use Response;
use Input;

class MealController extends BaseController {


	/**
     * MealRecipe Model
     * @var MealRecipe
     */
	protected $meals_recipes;

	/**
     * MealTag Model
     * @var MealTag
     */
	protected $meals_tags;

	// public function __construct( MealRecipe $meals_recipes, MealTag $meals_tags)
 //    {
 //    	$this->meals_recipes = $meals_recipes;
 //    	$this->meals_tags = $meals_tags;
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

	        $collection = \Models\Meal::orderBy('week_number')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Meal::count();
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
        return View::make('meals.create');
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
			$meal = new \Models\Meal;
			$input = Input::all();

			foreach($meal->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$meal->$field = $input[$field];
				}
			}

			if ( $meal->validate() ) {
				$meal->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $meal->toArray(),
						'message'	=> 'New Meal created sucessfully!'
					),
					201
				);

				$response->header('Location', '/meal/'.$meal->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $meal->errors()->toArray(),
						'message'	=> 'Error adding Meal!'
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
					'data'		=> $meal->toArray(),
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
			$meal = \Models\Meal::find($id);
			if(count($meal) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $meal->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Meal with id: '.$id
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
        return View::make('meals.edit');
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
			$meal = \Models\Meal::find($id);
			$input = Input::all();

			if(!is_null($meal))
			{
				foreach(\Models\Meal::fields() as $field)
				{
					if(isset($input[$field]))
					{
						$meals->$field = $input[$field];
					}
				}

				if( $meal->validate()){
					$meal->save();
					return parent::buildJsonResponse(
						array(
							'success'	=> $status,
							'data'		=> $meal->toArray(),
							'message'	=> 'Meal updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> $status,
							'data'		=> $meal->errors()->toArray(),
							'message'	=> 'Error updating Meal!'
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
						'message'	=> 'Could not find Meal with id: '.$id
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
			$meal = \Models\Meal::find($id);

			if(!is_null($meal))
			{
				$status = $meal->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $meal->toArray(),
						'message'	=> ($status) ? 'Meal deleted successfully!' : 'Error occured while deleting Meal'
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Meal with id: '.$id
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

			if ( \Models\Meal::find($id) ) {
		        $collection = \Models\Meal::find($id)->recipes()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\Meal::find($id)->recipes()->count();
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
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find MealsRecipes for Meal id : '.$id
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

			if ( \Models\Meal::find($id) ) {
		        $collection = \Models\Meal::find($id)->tags()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\Meal::find($id)->tags()->count();
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
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find MealTags for Meal id : '.$id
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
