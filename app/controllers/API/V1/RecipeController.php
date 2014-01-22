<?php
namespace API\V1;
use \BaseController;
use \Model\Recipe;
use \Model\RecipeIngredient;
use \Model\Picture;
use \Model\RecipeReview;

class RecipeController extends BaseController {


	/**
     * RecipeIngredient Model
     * @var RecipeIngredient
     */
	protected $recipe_ingredients;

	/**
     * Picture Model
     * @var Picture
     */
	protected $pictures;

	/**
     * RecipeReview Model
     * @var RecipeReview
     */
	protected $recipe_reviews;

	public function __construct(RecipeIngredient $recipe_ingredients, Picture $pictures, RecipeReview $recipe_reviews)
    {
    	$this->recipe_ingredients = $recipe_ingredients;
    	$this->pictures = $pictures;
    	$this->recipe_reviews = $recipe_reviews;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return Recipe::get();
        // return View::make('recipes.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('recipes.create');
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
		return Recipe::find($id);
        // return View::make('recipes.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('recipes.edit');
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

	public function recipe_ingredients($recipe_id)
	{
		$recipe_ingredients = $this->recipe_ingredients->getRecipeIngredientsByRecipe($recipe_id);
		return $recipe_ingredients;
	}
	public function pictures($recipe_id)
	{
		$pictures = $this->pictures->getPicturesByRecipe($recipe_id);
		return $pictures;
	}
	public function reviews($recipe_id)
	{
		$reviews = $this->recipe_reviews->getReviewsByRecipe($recipe_id);
		return $reviews;
	}

}
