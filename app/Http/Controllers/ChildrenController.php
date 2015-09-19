<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \Response;
use \Input;
use \Validator;

use App\Children;
use App\User;
use App\ChildCheckin;

class ChildrenController extends Controller {

	public function __construct(Children $children, User $user, ChildCheckin $child_checkin){
		$this->children = $children;
		$this->checkin = $child_checkin;
		$this->user = $user;
		$this->facilityID = $this->getFacility();
	}

	/**
	 * authorized_pickup                 Handles the formatting of authorized adult to pickup child.
	 * @param  array $contacts           The contacts to check for authorization
	 * @return array                     The authorized adults to pickup child.
	 */
	protected function authorized_pickup($contacts)
	{
		$authorized_pickup = [];
		foreach ($contacts as $contact) {
			if($contact->pivot->pickup) {
				$contact->relationship = $contact->pivot->relationship;
				$contact->pickup = (bool)$contact->pivot->pickup;
				unset($contact->pivot);
				array_push($authorized_pickup, $contact);
			}
		}
		
		return $authorized_pickup;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$children = $this->children->where('facility_id', $this->facilityID)
		->with('checkins')
		->with('parents')
		->with('emergencyContacts')
		->get();

		foreach ($children as $child) {
			$child->authorized_pickup = array_merge($this->authorized_pickup($child->parents), $this->authorized_pickup($child->emergencyContacts));
			foreach ($child->emergencyContacts as $ec) {
				$ec->relationship = $ec->pivot->relationship;
				$ec->pickup = (bool)$ec->pivot->pickup;
				unset($ec->pivot);
			}
		}


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
		$child = $this->children->where('facility_id', $this->facilityID)
		->where('id', $id)
		->with('checkins')
		->with('parents')
		->with('emergencyContacts')
		->first();

		$child->authorized_pickup = array_merge($this->authorized_pickup($child->parents), $this->authorized_pickup($child->emergencyContacts));
		foreach ($child->emergencyContacts as $ec) {
			$ec->relationship = $ec->pivot->relationship;
			$ec->pickup = (bool)$ec->pivot->pickup;
			unset($ec->pivot);
		}

		return Response::json([
			'success' => true,
			'data' => $child
		], 200);
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

	/**
	 * contacts Handles outputting the child's contacts
	 * @return Response
	 */
	public function contacts($id)
	{
		$children = $this->children->find($id);
		
		$emergencyContacts = $children->emergencyContacts()->get();
		$parents = $children->parents()->get();

		$guardians = [];
		$emergency = [];

		foreach($parents as $parent){
			$parent['relationship'] = $parent->pivot->relationship;
			unset($parent->pivot);
			array_push($guardians, $parent);
		}

		foreach($emergencyContacts as $ec){
			$ec['relationship'] = $ec->pivot->relationship;
			unset($ec->pivot);
			array_push($emergency, $ec);
		}

		return Response::json([
			'success' => true,
			'data' => [
				'parents' => $guardians,
				'emergency' => $emergency
			]
		], 200);
	}

	/**
	 * isCheckedIn Is the child checked in?
	 * @param  int  $childId Child Id
	 * @return boolean		 Is the child checked in?
	 */
	private function isCheckedIn($childId)
	{
		$checkedIn = $this->checkin
		->where('facility_id', $this->facilityID)
		->where('child_id', $childId)
		->where('checked_in', true)
		->where('checked_out', false)
		->first();

		if($checkedIn){
			return true;
		}
		return false;
	}

	/**
	 * checkin Checkin a child
	 * @return Response
	 */
	public function checkin()
	{
		//Checkin Child
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

		//now lets see if already checked in...
		if($this->isCheckedIn($data['childId'])){
			return Response::json([
				'success' => false,
				'error' => [ [ 'checkin' => 'this child is already checked in.' ] ]
			], 400);
		}

		$child = $this->children->find($data['childId']);

		$checkin = new ChildCheckin;
		$checkin->facility_id = $this->facilityID;
		$checkin->child_id = $child->id;
		$checkin->checked_in = true;
		$checkin->time_in = new \Datetime;
		$checkin->save();

		return Response::json([
			'success' => true,
			'msg' => 'The child has been checked in.'
		], 200);
	}

	/**
	 * checkout Checkout a child
	 * @return Response
	 */
	public function checkout()
	{
		//Checkout Child
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

		//now lets see if already checked in...
		if(!$this->isCheckedIn($data['childId'])){
			return Response::json([
				'success' => false,
				'error' => [ [ 'checkout' => 'this child has not been checked in.' ] ]
			], 400);
		}

		$checkin = $this->checkin
		->where('facility_id', $this->facilityID)
		->where('child_id', $data['childId'])
		->where('checked_in', true)
		->where('checked_out', false)
		->first();
	
		$checkinId = $checkin->id;

		$checkout = $this->checkin->find($checkinId);
		$checkout->checked_out = true;
		$checkout->time_out = new \Datetime;
		$checkout->save();

		return Response::json([
			'success' => true,
			'msg' => 'The child has been checked out.'
		], 200);
	}
}
