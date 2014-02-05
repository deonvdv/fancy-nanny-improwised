<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class RecipeIngredientController extends BaseController {

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

        $collection = \Models\RecipeIngredient::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\RecipeIngredient::count();
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
		$recipeingredients = new \Models\RecipeIngredient;
		$input = Input::all();

		foreach($recipeingredients->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$recipeingredients->$field = $input[$field];
			}
		}

		try
		{
			$status = $recipeingredients->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipeingredients->toArray(),
					'message'	=> 'New RecipeIngredient created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $recipeingredients->toArray(),
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
		try
		{
			$recipeingredients = \Models\RecipeIngredient::find($id);
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
						'message'	=> 'Can not find RecipeIngredients with id:'.$id
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
		$recipeingredients = \Models\RecipeIngredient::find($id);
		$input = Input::all();

		if(!is_null($recipeingredients))
		{
			foreach(\Models\RecipeIngredient::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$recipeingredients->$field = $input[$field];
				}
			}

			$status = $recipeingredients->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipeingredients->toArray(),
					'message'	=> 'RecipeIngredient updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find RecipeIngredient with id '.$id
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
		$recipeingredients = \Models\RecipeIngredient::find($id);

		if(!is_null($recipeingredients))
		{
			$status = $recipeingredients->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipeingredients->toArray(),
					'message'	=> ($status) ? 'RecipeIngredient deleted successfully!' : 'Error occured while deleting RecipeIngredient'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find RecipeIngredient with id '.$id
				),
				404
			);
		}
	}

}
