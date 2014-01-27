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
	public function index($page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

        $collection = \Models\Meal::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Meal::count();
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
        // return View::make('meals.index');
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
		$meals = \Models\Meal::find($id);
		if(count($meals) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $meals->toArray(),
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
					'message'	=> 'Can not find Meals ...'
				),
				404
			);
		}
        // return View::make('meals.show');
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

	public function recipes($id)
	{
		$mealsRecipe = $this->meals_recipes->getMealRecipesByMeal($id);
		$msg = json_decode($mealsRecipe);
		if(count($msg) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $mealsRecipe->toArray(),
					'message' => 'MealsRecipes ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find MealsRecipes for Meal id : '.$id
				),
				404
			);
		}
	}
	public function tags($id)
	{
		$mealTags = $this->meals_tags->getMealTagsByMeal($id);
		$msg = json_decode($mealTags);
		if(count($msg) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $mealTags->toArray(),
					'message' => 'MealsTag ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find MealsTags for Meal id : '.$id
				),
				404
			);
		}
	}
}
