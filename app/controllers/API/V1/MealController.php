<?php
namespace API\V1;
use \BaseController;
use \Model\Meal;
use \Model\MealRecipe;
use \Model\MealTag;

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

	public function __construct( MealRecipe $meals_recipes, MealTag $meals_tags)
    {
    	$this->meals_recipes = $meals_recipes;
    	$this->meals_tags = $meals_tags;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Meal::get();
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
		return Meal::find($id);
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
		return $mealsRecipe;
	}
	public function tags($id)
	{
		$mealTags = $this->meals_tags->getMealTagsByMeal($id);
		return $mealTags;
	}
}
