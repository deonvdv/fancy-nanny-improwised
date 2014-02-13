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
	public function index($page = 1, $itemsPerPage = 20)
	{
		try
		{
			$message      = array();
			$page         = (int) $page < 1 ? 1 : $page;
			$itemsPerPage = (int) $itemsPerPage < 1 ? 20 : $itemsPerPage;
			$skip         = ($page-1)*$itemsPerPage;

	        $collection = \Models\Document::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\Document::count();
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

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $documents->toArray(),
					'message'	=> 'New Document created sucessfully!'
				)
			);
		}
		catch(\Exception $e)
		{
			return parent::buildJsonResponse(
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
		try {
			$document = \Models\Document::find($id);
			if(count($document) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $document->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Document with id: '.$id
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

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $documents->toArray(),
					'message'	=> 'Document updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Document with id: '.$id
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
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $documents->toArray(),
					'message'	=> ($status) ? 'Document deleted successfully!' : 'Error occured while deleting Document'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find Document with id: '.$id
				),
				404
			);
		}
	}

}
