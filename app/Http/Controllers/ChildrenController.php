<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \Response;
use \Input;
use \Validator;

use App\Children;
use App\User;

class ChildrenController extends Controller {

	public function __construct(Children $children, User $user){
		$this->children = $children;
		$this->user = $user;
		$this->facilityID = $this->getFacility();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$children = $this->children->where('facility_id', $this->facilityID)->get();
		return Response::json([
			'success' => true,
			'data' => $children
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
		//Create New Child
		$data = Input::get('data');
		$rules = $this->children->create_rules;

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
		$child_dob = strtotime($data['dob']);
		$data['dob'] = date("Y-m-d", $child_dob);
		
		$children = new Children;
		$children->facility_id = $this->facilityID;
		foreach($data as $key => $val){
			$children->{$key} = $val;
		}
		$children->save();

		return Response::json([
			'success' => true,
			'msg' => 'child successfully created.'
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
		//Update Child
		$data = Input::get('data');
		$rules = $this->children->update_rules;

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
		if(isset($data['dob'])){
			$child_dob = strtotime($data['dob']);
			$data['dob'] = date("Y-m-d", $child_dob);
		}
		
		$children =  $this->children->find($id);
		$children->facility_id = $this->facilityID;
		foreach($data as $key => $val){
			$children->{$key} = $val;
		}
		$children->save();

		return Response::json([
			'success' => true,
			'msg' => 'child updated successfully.'
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
		$child = $this->children->find($id);
		$child->delete();
		return Response::json([
			'success' => true,
			'msg' => 'child successfully deleted.'
		], 200);
	}

}
