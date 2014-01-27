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
	public function index($page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

        $collection = \Models\Ingredient::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Ingredient::count();
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
        // return View::make('ingredients.index');
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
		$ingredients = new \Models\Ingredient;
		$input = Input::all();

		foreach($ingredients->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$ingredients->$field = $input[$field];
			}
		}

		try
		{
			$status = $ingredients->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $ingredients->toArray(),
					'message'	=> 'New Ingredient created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $ingredients->toArray(),
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
		$ingredients = \Models\Ingredient::find($id);
		if(count($ingredients) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $ingredients->toArray(),
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
					'message'	=> 'Can not find Ingredients ...'
				),
				404
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

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $ingredients->toArray(),
					'message'	=> 'Ingredient updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Ingredient with id '.$id
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
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $ingredients->toArray(),
					'message'	=> ($status) ? 'Ingredient deleted successfully!' : 'Error occured while deleting Ingredient'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Ingredient with id '.$id
				),
				404
			);
		}
	}

}
