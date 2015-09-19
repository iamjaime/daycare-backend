<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use App\Facility;

use \Auth;

use \Response;
use \Input;
use \Validator;

class SigninController extends Controller {

	public function __construct(User $user, Facility $facility){
		$this->user = $user;
		$this->facilities = $facility;
		$this->facilityID = $this->getFacility();
	}

	/**
	 * signin Handles the signing in process
	 * @return Response
	 */
	public function signin(){
		
		//Authenticate user
		$data = Input::get('data');
		$rules = $this->user->signin_rules;

		//validate....
		$validator = Validator::make($data, $rules);
		if ($validator->fails()){
			$messages = $validator->messages();
		    return Response::json([
			    	'success' => false,
			    	'error' => $messages
		    	], 400);
		}

		//If validation success then lets get the user info
		if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
        {
        	$user = Auth::user();
        	$data['id'] = $user->id;
        	$usr = $this->user->where('id', $user->id)->with('roles')->first();
        	unset($usr->password);
        	foreach($usr->roles as $roles){
        		$role = $roles->type;
        		$facilityID = $roles->pivot->facility_id;
        	}
        	//check the user role and facility that user belongs to...
        	switch($role){
        		case 'admin':
        		$facilities = $this->facilities->where('user_id', $user->id)->get(); 
        		$data['role'] = $role;
        		$data['facilities'] = $facilities;
        		break;

        		case 'parent':
        		$facilities = $this->facilities->find($facilityID)->get();
        		$data['role'] = $role;
        		$data['facilities'] = $facilities;
        		break;

        		case 'staff':
        		$facilities = $this->facilities->find($facilityID)->get();
        		$data['role'] = $role;
        		$data['facilities'] = $facilities;
        		break;
        	}
        	
            return Response::json([
				'success' => true,
				'data' => $data
			], 200);
        }	

		return Response::json([
			'success' => false,
			'error' => [ ['Invalid Authentication'] ]
		], 401);
	}

}
