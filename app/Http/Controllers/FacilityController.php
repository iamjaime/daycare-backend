<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Facility;

use \Response;
use \Input;
use \Validator;

class FacilityController extends Controller {

	public function __construct(Facility $facility){
		$this->facility = $facility;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Get All Facilities
		$allFacilities = $this->facility->all();
		return Response::json([
			'success' => true,
			'data' => $allClients
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
		//Create New Client
		$data = Input::get('data');
		$rules = $this->facility->create_rules;

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
		//But first lets make a token...
		$token = hash('sha256', Str::random(10),false);

		$facility = new Facility;
		$facility->user_id = $data['user_id'];
		$facility->name = $data['name'];
		$facility->api_auth_token = $token;
		$facility->save();

		return Response::json([
			'success' => true,
			'data' => $data
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
		//Create New Client
		$data = Input::get('data');
		//Set the ignore id for validation.
		$rules = $this->facility->updateRules($id);
		
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
		//But first we should probably re-generate an auth token...
		$token = hash('sha256', Str::random(10),false);

		$facility = $this->facility->findOrFail($id);
		$facility->user_id = $data['user_id'];
		$facility->name = $data['name'];
		$facility->api_auth_token = $token;
		$facility->save();

		return Response::json([
			'success' => true,
			'data' => $data
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
		//
	}
}
