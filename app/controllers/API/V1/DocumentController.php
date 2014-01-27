<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class DocumentController extends BaseController {

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

        $collection = \Models\Document::skip($skip)->take($itemPerPage)->get();
		$itemCount	= \Models\Document::count();
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
        // return View::make('documents.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('documents.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$documents = new \Models\Document;
		$input = Input::all();

		foreach($documents->fields() as $field)
		{
			if(isset($input[$field]))
			{
				$documents->$field = $input[$field];
			}
		}

		try
		{
			$status = $documents->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $documents->toArray(),
					'message'	=> 'New Document created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> $documents->toArray(),
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
		$documents = \Models\Document::find($id);
		if(count($documents) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $documents->toArray(),
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
					'message'	=> 'Can not find Documents ...'
				),
				404
			);
		}
        // return View::make('documents.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('documents.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$documents = \Models\Document::find($id);
		$input = Input::all();

		if(!is_null($documents))
		{
			foreach(\Models\Document::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$documents->$field = $input[$field];
				}
			}

			$status = $documents->save();

			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $documents->toArray(),
					'message'	=> 'Document updated sucessfully!'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Document with id '.$id
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
		$documents = \Models\Document::find($id);

		if(!is_null($documents))
		{
			$status = $documents->delete();
			return Response::json(
				array(
					'success'	=> $status,
					'data'		=> $documents->toArray(),
					'message'	=> ($status) ? 'Document deleted successfully!' : 'Error occured while deleting Document'
				)
			);
		}
		else
		{
			return Response::json(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Can not find Document with id '.$id
				),
				404
			);
		}
	}

}
