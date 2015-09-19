<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \Response;
use \Input;
use \Validator;

use App\Allergies;
use App\Children;

class AllergiesController extends Controller {

	public function __construct(Allergies $allergies, Children $children){
		$this->children = $children;
		$this->allergies = $allergies;
		$this->facilityID = $this->getFacility();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$allergies = $this->allergies->where('facility_id', $this->facilityID)->get();
		return Response::json([
			'success' => true,
			'data' => $allergies
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
		//Create New Allergy for Child
		$data = Input::get('data');
		$rules = $this->allergies->create_rules;

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
		
		$allergies = new Allergies;
		$allergies->facility_id = $this->facilityID;
		$allergies->child_id = $data['childId'];
		unset($data['childId']);
		foreach($data as $key => $val){
			$allergies->{$key} = $val;
		}
		$allergies->save();

		return Response::json([
			'success' => true,
			'msg' => 'child allergy successfully added.'
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
		//Update Allergy for Child
		$data = Input::get('data');
		$rules = $this->allergies->update_rules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		//If validation success then update record
		$allergies = $this->allergies->find($id);
		$allergies->facility_id = $this->facilityID;
		$allergies->child_id = $data['childId'];
		unset($data['childId']);
		foreach($data as $key => $val){
			$allergies->{$key} = $val;
		}
		$allergies->save();

		return Response::json([
			'success' => true,
			'msg' => 'child allergy successfully updated.'
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
		$allergies = $this->allergies->find($id);
		$allergies->delete();
		return Response::json([
			'success' => true,
			'msg' => 'You have successfully deleted the child\'s allergy.'
		], 200);
	}

}
