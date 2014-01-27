<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

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


	/**
     * RecipeCategory Model
     * @var RecipeCategory
     */
	protected $recipes_categories;

	/**
     * RecipeTag Model
     * @var RecipeTag
     */
	protected $recipe_tags;

	// public function __construct(RecipeIngredient $recipe_ingredients, Picture $pictures, RecipeReview $recipe_reviews, RecipeCategory $recipes_categories, RecipeTag $recipe_tags)
 //    {
 //    	$this->recipe_ingredients = $recipe_ingredients;
 //    	$this->pictures = $pictures;
 //    	$this->recipe_reviews = $recipe_reviews;
 //    	$this->recipes_categories = $recipes_categories;
 //    	$this->recipe_tags = $recipe_tags;
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

        $collection = \Models\Recipe::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Recipe::count();
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
		$recipe = new \Models\Recipe;
		$input = Input::all();

		foreach($recipe->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$recipe->$field = $input[$field];
			}
		}

		try
		{
			$status = $recipe->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipe->toArray(),
					'message'	=> 'New Recipe created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $recipe->toArray(),
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
		$recipes = \Models\Recipe::find($id);
		if(count($recipes) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $recipes->toArray(),
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
					'message'	=> 'Can not find Recipes ...'
				),
				404
			);
		}
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
		$recipe = \Models\Recipe::find($id);
		$input = Input::all();

		if(!is_null($recipe))
		{
			foreach(\Models\Recipe::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$recipe->$field = $input[$field];
				}
			}

			$status = $recipe->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipe->toArray(),
					'message'	=> 'Recipe updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Recipe with id '.$id
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
		$recipe = \Models\Recipe::find($id);

		if(!is_null($recipe))
		{
			$status = $recipe->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $recipe->toArray(),
					'message'	=> ($status) ? 'Recipe deleted successfully!' : 'Error occured while deleting Recipe'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Recipe with id '.$id
				),
				404
			);
		}
	}

	public function recipe_ingredients($recipe_id, $page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\RecipeIngredient::find($recipe_id) ) {
	        $collection = \Models\RecipeIngredient::where('recipe_id', '=', $recipe_id)->get();
			$itemCount	= $collection->count();
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
		} else {
        	return Response::json(
        		array(
        			'success'	=> false,
        			'data'		=> null,
					'message'	=> 'Can not find Recipe Reviews with recipe id :'.$recipe_id
        		),
        		404
        	);
		}
	}
	public function pictures($recipe_id)
	{
		$pictures = $this->pictures->getPicturesByRecipe($recipe_id);
		$msg = json_decode($pictures);
		if(count($msg) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $pictures->toArray(),
					'message' => 'Pictures ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Pictures for Recipe id : '.$recipe_id
				),
				404
			);
		}
	}
	public function reviews($recipe_id, $page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

		if ( \Models\RecipeReview::find($recipe_id) ) {
	        $collection = \Models\RecipeReview::where('recipe_id', '=', $recipe_id)->get();
			$itemCount	= $collection->count();
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
		} else {
        	return Response::json(
        		array(
        			'success'	=> false,
        			'data'		=> null,
					'message'	=> 'Can not find Recipe Reviews with recipe id :'.$recipe_id
        		),
        		404
        	);
		}
	}
	public function categoried($recipe_id)
	{
		$category = $this->recipes_categories->getCategoryByRecipe($recipe_id);
		$msg = json_decode($category);
		if(count($msg) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $category->toArray(),
					'message' => 'Category ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Category for Recipe id : '.$recipe_id
				),
				404
			);
		}
	}
	public function tags($recipe_id)
	{
		$tags = $this->recipe_tags->getTagByRecipes($recipe_id);
		$msg = json_decode($tags);
		if(count($msg) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $tags->toArray(),
					'message' => 'Tags ...'
					)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Tags for Recipe id : '.$recipe_id
				),
				404
			);
		}
	}
}
