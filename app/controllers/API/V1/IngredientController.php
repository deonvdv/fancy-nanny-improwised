<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class IngredientController extends BaseController {

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

	        $collection = \Models\Ingredient::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Ingredient::count();
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
        return View::make('ingredients.create');
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
			$ingredient = new \Models\Ingredient;
			$input = Input::all();

			foreach($ingredient->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$ingredient->$field = $input[$field];
				}
			}

			if ( $ingredient->validate() ) {
				$ingredient->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $ingredient->toArray(),
						'message'	=> 'New Ingredient created sucessfully!'
					),
					201
				);

				$response->header('Location', '/ingredient/'.$ingredient->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $ingredient->errors()->toArray(),
						'message'	=> 'Error adding Ingredient!'
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
					'data'		=> $ingredient->toArray(),
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
			$ingredient = \Models\Ingredient::find($id);
			if(count($ingredient) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $ingredient->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Ingredient with id: '.$id
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
		
        // return View::make('ingredients.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('ingredients.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$ingredients = \Models\Ingredient::find($id);
		$input = Input::all();

		if(!is_null($ingredients))
		{
			foreach(\Models\Ingredient::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$ingredients->$field = $input[$field];
				}
			}

			$status = $ingredients->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $ingredients->toArray(),
					'message'	=> 'Ingredient updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Ingredient with id: '.$id
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
		$ingredients = \Models\Ingredient::find($id);

		if(!is_null($ingredients))
		{
			$status = $ingredients->delete();
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $ingredients->toArray(),
					'message'	=> ($status) ? 'Ingredient deleted successfully!' : 'Error occured while deleting Ingredient'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Ingredient with id: '.$id
				),
				404
			);
		}
	}

}
