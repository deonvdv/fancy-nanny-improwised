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
	public function index($page = 1, $itemsPerPage = 20)
	{
		try
		{
			$message      = array();
			$page         = (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 20 : $itemsPerPage;
			$skip         = ($page-1)*$itemsPerPage;

	        $collection = \Models\RecipeIngredient::orderBy('quantity')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\RecipeIngredient::count();
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
        return View::make('recipeingredients.create');
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
			$recipeingredients = new \Models\RecipeIngredient;
			$input = Input::all();

			foreach($recipeingredient->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$recipeingredient->$field = $input[$field];
				}
			}

			if ( $recipeingredient->validate() ) {
				$recipeingredient->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $recipeingredient->toArray(),
						'message'	=> 'New RecipeIngredient created sucessfully!'
					),
					201
				);

				$response->header('Location', '/recipeingredient/'.$recipeingredient->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $recipeingredient->errors()->toArray(),
						'message'	=> 'Error adding RecipeIngredient!'
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
					'data'		=> $recipereview->toArray(),
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
			$recipeingredient = \Models\RecipeIngredient::find($id);
			if(count($recipeingredient) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $recipeingredient->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find RecipeIngredient with id: '.$id
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

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $recipeingredients->toArray(),
					'message'	=> 'RecipeIngredient updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find RecipeIngredient with id: '.$id
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
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $recipeingredients->toArray(),
					'message'	=> ($status) ? 'RecipeIngredient deleted successfully!' : 'Error occured while deleting RecipeIngredient'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find RecipeIngredient with id: '.$id
				),
				404
			);
		}
	}

}
