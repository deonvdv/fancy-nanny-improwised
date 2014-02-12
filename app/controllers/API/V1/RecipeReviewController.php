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

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $recipereviews->toArray(),
					'message'	=> 'New RecipeReview created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return parent::buildJsonResponse(
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
		try {
			$recipereview = \Models\RecipeReview::find($id);
			if(count($recipereview) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $recipereview->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find RecipeReview with id: '.$id
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

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $recipereviews->toArray(),
					'message'	=> 'RecipeReview updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find RecipeReview with id: '.$id
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
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $recipereviews->toArray(),
					'message'	=> ($status) ? 'RecipeReview deleted successfully!' : 'Error occured while deleting RecipeReview'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find RecipeReview with id: '.$id
				),
				404
			);
		}
	}

}
