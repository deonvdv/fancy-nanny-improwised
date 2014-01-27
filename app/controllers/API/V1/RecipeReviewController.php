<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class RecipeReviewController extends BaseController {

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

        $collection = \Models\RecipeReview::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\RecipeReview::count();
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
        // return View::make('recipereviews.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('recipereviews.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$recipereviews = new \Models\RecipeReview;
		$input = Input::all();

		foreach($recipereviews->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$recipereviews->$field = $input[$field];
			}
		}

		try
		{
			$status = $recipereviews->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipereviews->toArray(),
					'message'	=> 'New RecipeReview created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $recipereviews->toArray(),
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
		$recipereviews = \Models\RecipeReview::find($id);
		if(count($recipereviews) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $recipereviews->toArray(),
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
					'message'	=> 'Can not find RecipeReviews ...'
				),
				404
			);
		}
        // return View::make('recipereviews.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('recipereviews.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$recipereviews = \Models\RecipeReview::find($id);
		$input = Input::all();

		if(!is_null($recipereviews))
		{
			foreach(\Models\RecipeReview::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$recipereviews->$field = $input[$field];
				}
			}

			$status = $recipereviews->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipereviews->toArray(),
					'message'	=> 'RecipeReview updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find RecipeReview with id '.$id
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
		$recipereviews = \Models\RecipeReview::find($id);

		if(!is_null($recipereviews))
		{
			$status = $recipereviews->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipereviews->toArray(),
					'message'	=> ($status) ? 'RecipeReview deleted successfully!' : 'Error occured while deleting RecipeReview'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find RecipeReview with id '.$id
				),
				404
			);
		}
	}

}
