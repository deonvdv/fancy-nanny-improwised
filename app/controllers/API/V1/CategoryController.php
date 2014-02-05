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
	public function index($page = 1)
	{
		$message 	= array();
		$page 		= (int) $page < 1 ? 1 : $page;
		$itemPerPage= (Input::get('item_per_page')) ? Input::get('item_per_page') : 20;
		$skip 		= ($page-1)*$itemPerPage;

        $collection = \Models\Category::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Category::count();
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
        // return View::make('categories.index');
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
		$category = new \Models\Category;
		$input = Input::all();

		foreach($category->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$category->$field = $input[$field];
			}
		}

		try
		{
			$status = $category->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $category->toArray(),
					'message'	=> 'New Category created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $category->toArray(),
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
			$category = \Models\Category::find($id);
			if(count($category) > 0)
			{
				return Response::json(
					array(
						'success' => true,
						'data'    => $category->toArray(),
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
						'message'	=> 'Can not find Category with id:'.$id
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

			$status = $category->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $category->toArray(),
					'message'	=> 'Category updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Category with id '.$id
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
		$category = \Models\Category::find($id);

		if(!is_null($category))
		{
			$status = $category->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $category->toArray(),
					'message'	=> ($status) ? 'Category deleted successfully!' : 'Error occured while deleting Category'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Category with id '.$id
				),
				404
			);
		}
	}

}
