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
	public function index($page = 1, $itemsPerPage = 20)
	{
		try
		{
			$message      = array();
			$page         = (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 20 : $itemsPerPage;
			$skip         = ($page-1)*$itemsPerPage;

	        $collection = \Models\Recipe::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Recipe::count();
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
        return View::make('recipes.create');
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
			$recipe = new \Models\Recipe;
			$input = Input::all();

			foreach($recipe->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$recipe->$field = $input[$field];
				}
			}

			if ( $recipe->validate() ) {
				$recipe->save();

				//Save ingredients along with Recipe
				if(isset($input["newIngredients"])) {
					foreach($input["newIngredients"] as $ingredient ) {

						$recipeIngredient = new \Models\RecipeIngredient;
						foreach ($recipeIngredient->fields() as $field) {
							if(isset($ingredient[$field])) {
								$recipeIngredient->$field = $ingredient[$field];
							}
						}
						$recipe->addRecipeIngredient($recipeIngredient);
					}
				}

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $recipe->toArray(),
						'message'	=> 'New Recipe created sucessfully!'
					),
					201
				);

				$response->header('Location', '/recipe/'.$recipe->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $recipe->errors()->toArray(),
						'message'	=> 'Error adding Recipe!'
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
					'data'		=> $recipe->toArray(),
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
			$recipe = \Models\Recipe::with(array('recipe_ingredients','recipe_ingredients.ingredient','recipe_ingredients.unit_of_measure','category','author'))->find($id);
			if(count($recipe) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $recipe->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Recipe with id: '.$id
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
		try
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

				if($recipe->validate()) {
					$recipe->save();
					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $recipe->toArray(),
							'message'	=> 'Recipe updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $recipe->errors()->toArray(),
							'message'	=> 'Error updating Recipe!'
						)
					);
				}				
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Recipe with id: '.$id
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
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
			$recipe = \Models\Recipe::find($id);

			if(!is_null($recipe))
			{
				$status = $recipe->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $recipe->toArray(),
						'message'	=> ($status) ? 'Recipe deleted successfully!' : 'Error occured while deleting Recipe'
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Recipe with id: '.$id
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

	public function recipe_ingredients($recipe_id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Recipe::find($recipe_id) ) {
		        $collection = \Models\RecipeIngredient::where('recipe_id', '=', $recipe_id)->get();
				$itemCount	= $collection->count();
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
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find RecipeIngredients with recipe id :'.$recipe_id
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

	public function pictures($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Recipe::find($id) ) {
		        $collection = \Models\Recipe::find($id)->pictures()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\Recipe::find($id)->pictures()->count();
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
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find Pictures for Recipe id:'.$id
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

	public function reviews($recipe_id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Recipe::find($recipe_id) ) {
		        $collection = \Models\RecipeReview::where('recipe_id', '=', $recipe_id)->get();
				$itemCount	= $collection->count();
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
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find Recipe Reviews with recipe id :'.$recipe_id
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

	public function categories($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Recipe::find($id) ) {
		        $collection = \Models\Recipe::find($id)->category()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\Recipe::find($id)->category()->count();
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
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find Category for Recipe id:'.$id
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

	public function tags($id, $page = 1)
	{
		try
		{
			$message 	= array();
			$page 		= (int) $page < 1 ? 1 : $page;
			$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
			$skip 		= ($page-1)*$itemPerPage;

			if ( \Models\Recipe::find($id) ) {
		        $collection = \Models\Recipe::find($id)->tags()->skip($skip)->take($itemPerPage)->get();
				$itemCount	= \Models\Recipe::find($id)->tags()->count();
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
			} else {
	        	return parent::buildJsonResponse(
	        		array(
	        			'success'	=> false,
	        			'data'		=> null,
						'message'	=> 'Could not find Tags for Recipe id:'.$id
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
}
