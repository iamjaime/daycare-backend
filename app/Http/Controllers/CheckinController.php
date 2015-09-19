<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \Response;
use \Input;
use \Validator;

use App\Checkin;
use App\Children;

class CheckinController extends Controller {

	public function __construct(Checkin $checkin, Children $children){
		$this->children = $children;
		$this->checkin = $checkin;
		$this->facilityID = $this->getFacility();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$checkins = $this->checkin->where('facility_id', $this->facilityID)->get();
		return Response::json([
			'success' => true,
			'data' => $checkins
		], 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Create New Checkin
		$data = Input::get('data');
		$rules = $this->checkin->create_rules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		//If validation success then insert record
		
		$checkin= new Checkin;
		$checkin->facility_id = $this->facilityID;
		$checkin->child_id = $data['childId'];
		$checkin->checked_in = true;
		$checkin->time_in = new \DateTime;
		$checkin->save();

		return Response::json([
			'success' => true,
			'msg' => 'Child Has Checked In Successfully.'
		], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Checkout
		$data = Input::get('data');
		$rules = $this->checkin->update_rules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		//If validation success then insert record
		
		$checkin = $this->checkin->find($id);
		$checkin->checked_out = true;
		$checkin->time_out = new \DateTime;
		$checkin->save();

		return Response::json([
			'success' => true,
			'msg' => 'Child Has Checked Out Successfully.'
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$checkin = $this->checkin->find($id);
		$checkin->delete();
		return Response::json([
			'success' => true,
			'msg' => 'Checkin record deleted.'
		], 200);
	}

}
