<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class TagController extends BaseController {

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

        $collection = \Models\Tag::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Tag::count();
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
        // return View::make('tags.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('tags.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$tag = new \Models\Tag;
		$input = Input::all();

		foreach($tag->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$tag->$field = $input[$field];
			}
		}

		try
		{
			$status = $tag->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $tag->toArray(),
					'message'	=> 'New Tag created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $tag->toArray(),
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
			$tag = \Models\Tag::find($id);
			if(count($tag) > 0)
			{
				return Response::json(
					array(
						'success' => true,
						'data'    => $tag->toArray(),
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
						'message'	=> 'Can not find Tag with id:'.$id,
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
		
        // return View::make('tags.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('tags.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tag = \Models\Tag::find($id);
		$input = Input::all();

		if(!is_null($tag))
		{
			foreach(\Models\Tag::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$tag->$field = $input[$field];
				}
			}

			$status = $tag->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $tag->toArray(),
					'message'	=> 'Tag updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Tag with id '.$id
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
		$tag = \Models\Tag::find($id);

		if(!is_null($tag))
		{
			$status = $tag->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $tag->toArray(),
					'message'	=> ($status) ? 'Tag deleted successfully!' : 'Error occured while deleting Tag'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Tag with id '.$id
				),
				404
			);
		}
	}

}
