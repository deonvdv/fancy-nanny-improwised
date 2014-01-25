<?php
namespace API\V1;
use \BaseController;
use \Model\RecipeIngredient;
use \Response;

class RecipeIngredientController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$recipeingredients = RecipeIngredient::get();
		if(count($recipeingredients) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $recipeingredients->toArray(),
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
					'message'	=> 'Can not find RecipeIngredients ...'
				),
				404
			);
		}
        // return View::make('recipeingredients.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('recipeingredients.create');
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
		$recipeingredients = RecipeIngredient::find($id);
		if(count($recipeingredients) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $recipeingredients->toArray(),
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
					'message'	=> 'Can not find RecipeIngredients ...'
				),
				404
			);
		}
        // return View::make('recipeingredients.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('recipeingredients.edit');
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

}
