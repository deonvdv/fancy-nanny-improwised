<?php
namespace API\V1;
use \BaseController;
use \Model\UnitMeasure;
use \Response;

class MeasureUnitController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unit_of_measure = UnitMeasure::get();
		if(count($unit_of_measure) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $unit_of_measure->toArray(),
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
					'message'	=> 'Can not find Unit of Measure ...'
				),
				404
			);
		}
        // return View::make('measureunits.index');
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$unit_of_measure = UnitMeasure::find($id);
		if(count($unit_of_measure) > 0)
		{
			return Response::json(
				array(
					'success' => true,
					'data'    => $unit_of_measure->toArray(),
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
					'message'	=> 'Can not find Unit of Measure ...'
				),
				404
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
