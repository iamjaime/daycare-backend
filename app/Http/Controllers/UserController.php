<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use \Response;
use \Input;
use \Validator;
use \Hash;

use App\User;
use App\Role;
use App\Children;
use App\ChildContact;
use App\ChildPhysician;
use App\Facility;

class UserController extends Controller {

	public function __construct(User $user, Children $children, ChildContact $child_contact, ChildPhysician $child_physician, Facility $facility){
		$this->user = $user;
		$this->children = $children;
		$this->child_contact = $child_contact;
		$this->child_physician = $child_physician;
		$this->facilityID = $this->getFacility();
		$this->facility = $facility;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Get All Users
		$allUsers = $this->user->all();
		return Response::json([
			'success' => true,
			'data' => $allUsers
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
		//Create New User
		$data = Input::get('data');
		$rules = $this->user->create_rules;

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
		$user = new User;
		$role = $data['role'];
		$findRole = Role::where('type', $role)->first();
		if(!$findRole){
			return Response::json([
				'success' => false,
				'error' => [
					'role' => 'The specified role does not exist!'
				]
			], 400);
		}
		$roleID = $findRole->id;
		
		$user->fill($data);
		$user->save();

		//now that we have a user record, lets attach the pivot table and save the user.
		$user->roles()->attach($roleID, ['facility_id' => $this->facilityID]);
		
		$children = $this->children->find($data['childId']);
		$children->emergencyContacts()->attach($user->id, ['facility_id' => $this->facilityID, 'relationship' => $data['relationship']]);

		return Response::json([
			'success' => true,
			'msg' => 'user successfully created.'
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
		$user = $this->user->find($id);
		$roles = $user->roles()->first();
		$user->role = $roles->type;

		return Response::json([
			'success' => true,
			'data' => $user
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
		//Update User
		$data = Input::get('data');
		$rules = $this->user->updateRules($id);

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}


		$role = $data['role'];
		$findRole = Role::where('type', $role)->first();
		if(!$findRole){
			return Response::json([
				'success' => false,
				'error' => [
					'role' => 'The specified role does not exist!'
				]
			], 400);
		}
		$roleID = $findRole->id;

		unset($data['role']); //remove from array

		//If validation success then insert record
		$user = $this->user->findOrFail($id);
		foreach($data as $key => $val){
			$user->{$key} = $val;
			if($key == "password"){
				$user->password = Hash::make($val);
			}
		}
		$user->save();

		//Lets Update the pivot table
		$oldRoleId = $user->roles()->first()->id;
		$user->roles()->updateExistingPivot($oldRoleId, ['role_id' => $roleID, 'facility_id' => $this->facilityID]);

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
		$user = $this->user->find($id);
		$user->delete();
		return Response::json([
			'success' => true,
			'msg' => 'the user has been successfully deleted.'
		], 200);
	}

	/**
	 * getUserFacilities Handles getting the facilities that a user belongs to.
	 * @return Response
	 */
	public function getUserFacilities(){
		$data = Input::get('data');
		$rules = $this->user->getFacilitiesRules;
		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}
		//after validation....
		$user = $this->user->find($data['userId']);
		$roles = $user->roles;
		$user_facilities = [];

		foreach($roles as $role){
		 array_push($user_facilities, $role->pivot->facility_id);
		}
		
		//get all facilities that this user belongs to.
		$facilities = $this->facility->whereIn('id', $user_facilities)->get();

		return Response::json([
			'success' => true,
			'data' => $facilities
		], 200);	
	}


	/**
	 * attachParent Handles attaching a child or children to a parent or parents.
	 * @return [type]     [description]
	 */
	public function attachParent()
	{
		//Attach Parent(s) to child(ren)
		$data = Input::get('data');
		$rules = $this->user->attachParentRules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		//lets attach the parent(s) to the child(ren)
		$parents = $data['parentIds'];
		
		if(!$this->validateParents($parents) )
		{
			return Response::json([
				'success' => false,
				'error' => [
					'parentIds' => 'please make sure that the user has a role as a parent and try again.'
				]
			], 400);
		}
		
		$children = $this->formatChildrenIdsForSync($data['childrenIds']);

		foreach($parents as $user)
		{
			$user = $this->user->find($user);
			$user->children()->sync($children);
		}

		return Response::json([
			'success' => true,
			'msg' => 'the following parents have been attached to the following children:',
			'parents' => $parents,
			'children' => $children
		], 200);

	}

	/**
	 * formatChildrenIdsForSync Formats the childrenIds for pivot table inserting. 
	 * @param  array $ids an array of the children ids.
	 * @return array      array of the formatted children.
	 */
	private function formatChildrenIdsForSync($ids)
	{
		foreach($ids as $id){
			$output[$id] = ['facility_id' => $this->facilityID];
		}

		return $output;
	}


	/**
	 * validateParents Validates the parentIds to make sure the user role is a parent.
	 * @param  array $parentIds array of parentIds
	 * @return response
	 */
	private function validateParents($parentIds)
	{
		$users = $this->user->whereIn('id', $parentIds)->get();
		foreach($users as $user){
			$user = $user->roles()->first();
			if($user->type != "parent"){
				return false;
			}
		}
		return true;
	}

	/**
	 * validateEmergencyContact Validates the contactIds to make sure the user role is an emergency contact.
	 * @param  array $contactIds array of contactIds
	 * @return response
	 */
	private function validateEmergencyContact($contactIds)
	{
		$users = $this->user->whereIn('id', $contactIds)->get();
		foreach($users as $user){
			$user = $user->roles()->first();
			if($user->type != "emergency_contact"){
				return false;
			}
		}
		return true;
	}

	/**
	 * validatePhysician Validates the contactIds to make sure the user role is a physician.
	 * @param  array $contactIds array of contactIds
	 * @return response
	 */
	private function validatePhysician($contactIds)
	{
		$users = $this->user->whereIn('id', $contactIds)->get();
		foreach($users as $user){
			$user = $user->roles()->first();
			if($user->type != "physician"){
				return false;
			}
		}
		return true;
	}

	/**
	 * attachContact Handles attaching a child or children to an emergency contact or contacts.
	 * @return [type]     [description]
	 */
	public function attachContact()
	{
		//Attach Parent(s) to child(ren)
		$data = Input::get('data');
		$rules = $this->children->attachContactRules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		//lets attach the contact(s) to the child(ren)
		$contacts = $data['contactId'];
		
		if(!$this->validateEmergencyContact(array($contacts)) )
		{
			return Response::json([
				'success' => false,
				'error' => [
					'contactId' => 'please make sure that the user has a role as an emergency_contact and try again.'
				]
			], 400);
		}
		
		//Check if contactId is already attached to childId
		if($this->contactAttachedToChild($data['contactId'], $data['childId']))
		{
			return Response::json([
				'success' => false,
				'error' => [
					'contactId' => 'This emergency_contact already belongs to this child!'
				]
			], 400);
		}

		$child = $this->children->find($data['childId']);
		$child->emergencyContacts()->attach([ $contacts => ['facility_id' => $this->facilityID, 'relationship' => $data['relationship']] ]);
		
		return Response::json([
			'success' => true,
			'msg' => 'the following emergency contacts have been attached to the following children:',
			'emergency_contact' => $contacts,
			'children' => $data['childId']
		], 200);

	}

	/**
	 * contactAttachedToChild Checks if the emergency contact is attached to a child
	 * @param  int $contactId The emergency_contact id
	 * @param  int $childId   The child_id
	 * @return BOOL           is the emergency_contact attached to the child?
	 */
	private function contactAttachedToChild($contactId, $childId)
	{
		$q = $this->child_contact
		->where('facility_id', $this->facilityID)
		->where('user_id', $contactId)
		->where('child_id', $childId)
		->first();
		if($q){
			return true;
		}
		return false;
	}

	/**
	 * physicianAttachedToChild Checks if the physician is attached to a child
	 * @param  int $contactId The physician id
	 * @param  int $childId   The child_id
	 * @return BOOL           is the physician attached to the child?
	 */
	private function physicianAttachedToChild($contactId, $childId)
	{
		$q = $this->child_physician
		->where('facility_id', $this->facilityID)
		->where('user_id', $contactId)
		->where('child_id', $childId)
		->first();
		if($q){
			return true;
		}
		return false;
	}

	/**
	 * attachPhysician Handles attaching a child or children to a physician or physicians.
	 * @return [type]     [description]
	 */
	public function attachPhysician()
	{
		//Attach Physician(s) to child(ren)
		$data = Input::get('data');
		$rules = $this->children->attachPhysicianRules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		//lets attach the physician(s) to the child(ren)
		$physician = $data['physicianId'];
		
		if(!$this->validatePhysician(array($physician)) )
		{
			return Response::json([
				'success' => false,
				'error' => [
					'physicianId' => 'please make sure that the user has a role as a physician and try again.'
				]
			], 400);
		}
		
		//Check if physicianId is already attached to childId
		if($this->physicianAttachedToChild($data['physicianId'], $data['childId']))
		{
			return Response::json([
				'success' => false,
				'error' => [
					'physicianId' => 'This physician already belongs to this child!'
				]
			], 400);
		}

		$child = $this->children->find($data['childId']);
		$child->physicians()->attach([ $physician => ['facility_id' => $this->facilityID, 'type' => $data['physicianType']] ]);
		
		return Response::json([
			'success' => true,
			'msg' => 'the following physician has been attached to the following child:',
			'physician' => $physician,
			'children' => $data['childId']
		], 200);

	}
}
