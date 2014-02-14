<?php
namespace API\V1;

use BaseController;
use Response;
use Input;

class CategoryController extends BaseController {

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

	        $collection = \Models\Category::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Category::count();
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
        return View::make('categories.create');
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
			$category = new \Models\Category;
			$input = Input::all();

			foreach($category->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$category->$field = $input[$field];
				}
			}

			if ( $category->validate() ) {
				$category->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $category->toArray(),
						'message'	=> 'New Category created sucessfully!'
					),
					201
				);

				$response->header('Location', '/category/'.$category->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $category->errors()->toArray(),
						'message'	=> 'Error adding Category!'
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
					'data'		=> $category->toArray(),
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
			$category = \Models\Category::with('parent')->find($id);
			if(count($category) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $category->toArray(),
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Category with id: '.$id
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
        return View::make('categories.edit');
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
			$category = \Models\Category::find($id);
			$input = Input::all();

			if(!is_null($category))
			{
				foreach(\Models\Category::fields() as $field)
				{
					if(isset($input[$field]))
					{
						$category->$field = $input[$field];
					}
				}

				if ( $category->validate() ) {
					$category->save();

					return parent::buildJsonResponse(
						array(
							'success'	=> true,
							'data'		=> $category->toArray(),
							'message'	=> 'Category updated sucessfully!'
						)
					);
				} else {
					return parent::buildJsonResponse(
						array(
							'success'	=> false,
							'data'		=> $category->errors()->toArray(),
							'message'	=> 'Error updating Category!'
						),
						400
					);
				}
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Category with id: '.$id
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
			$category = \Models\Category::find($id);

			if(!is_null($category))
			{
				$status = $category->delete();
				return parent::buildJsonResponse(
					array(
						'success'	=> $status,
						'data'		=> $category->toArray(),
						'message'	=> ($status) ? 'Category deleted successfully!' : 'Error occured while deleting Category'
					)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Category with id: '.$id
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
