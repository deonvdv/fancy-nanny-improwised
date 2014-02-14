<?php
namespace API\V1;
use BaseController;
use Response;
use Input;

class MeasureUnitController extends BaseController {

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

	        $collection = \Models\UnitOfMeasure::orderBy('name')->skip($skip)->take($itemsPerPage)->get();
			$itemCount	= \Models\UnitOfMeasure::count();
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
        return View::make('measureunits.create');
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
			$units_of_measure = new \Models\UnitOfMeasure;
			$input = Input::all();

			foreach($units_of_measure->fields() as $field)
			{
				if(isset($input[$field]))
				{
					$units_of_measure->$field = $input[$field];
				}
			}

			if ( $units_of_measure->validate() ) {
				$units_of_measure->save();

				$response = parent::buildJsonResponse(
					array(
						'success'	=> true,
						'data'		=> $units_of_measure->toArray(),
						'message'	=> 'New UnitsOfMeasure created sucessfully!'
					),
					201
				);

				$response->header('Location', '/units_of_measure/'.$units_of_measure->id);

				return $response;
			} else {
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> $units_of_measure->errors()->toArray(),
						'message'	=> 'Error adding UnitsOfMeasure!'
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
					'data'		=> $units_of_measure->toArray(),
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
			$unit_of_measure = \Models\UnitOfMeasure::find($id);
			if(count($unit_of_measure) > 0)
			{
				return parent::buildJsonResponse(
					array(
						'success' => true,
						'data'    => $unit_of_measure->toArray(),
						)
				);
			}
			else
			{
				return parent::buildJsonResponse(
					array(
						'success'	=> false,
						'data'		=> null,
						'message'	=> 'Could not find Unit of Measure with id: '.$id
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
		
        // return View::make('measureunits.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('measureunits.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$units_of_measures = \Models\UnitOfMeasure::find($id);
		$input = Input::all();

		if(!is_null($units_of_measures))
		{
			foreach(\Models\UnitOfMeasure::fields() as $field)
			{
				if(isset($input[$field]))
				{
					$units_of_measures->$field = $input[$field];
				}
			}

			$status = $units_of_measures->save();

			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $units_of_measures->toArray(),
					'message'	=> 'UnitOfMeasure updated sucessfully!'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find UnitOfMeasure with id: '.$id
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
		$units_of_measures = \Models\UnitOfMeasure::find($id);

		if(!is_null($units_of_measures))
		{
			$status = $units_of_measures->delete();
			return parent::buildJsonResponse(
				array(
					'success'	=> $status,
					'data'		=> $units_of_measures->toArray(),
					'message'	=> ($status) ? 'UnitOfMeasure deleted successfully!' : 'Error occured while deleting UnitOfMeasure'
				)
			);
		}
		else
		{
			return parent::buildJsonResponse(
				array(
					'success'	=> false,
					'data'		=> null,
					'message'	=> 'Could not find UnitOfMeasure with id: '.$id
				),
				404
			);
		}
	}

}
