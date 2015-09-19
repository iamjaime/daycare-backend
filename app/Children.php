<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Children extends Model {

	protected $table = 'children';

	protected $fillable = ['first_name', 'last_name', 'dob', 'gender', 'blood_type'];

	public $create_rules = [
		'first_name' => 'required',
		'last_name' => 'required',
		'dob' => 'required|date',
		'gender' => 'required',
		'blood_type' => 'sometimes|required'
	];

	public $update_rules = [
		'first_name' => 'sometimes|required',
		'last_name' => 'sometimes|required',
		'dob' => 'sometimes|required|date',
		'gender' => 'sometimes|required',
		'blood_type' => 'sometimes|required'
	];

	public $attachContactRules = [
		'contactId' => 'required|exists:users,id',
		'childId' => 'required|exists:children,id',
		'relationship' => 'required'
	];

	public $attachPhysicianRules = [
		'physicianId' => 'required|exists:users,id',
		'physicianType' => 'required', //physician type
		'childId' => 'required|exists:children,id'
	];	

	public function parents()
	{
		//withPivot(['id']) returns the selected fields on the pivot table.
        //return $this->belongsToMany('App\User', 'child_parent', 'user_id', 'child_id')->withPivot(['id']);
		return $this->belongsToMany('App\User', 'child_parent', 'child_id', 'user_id')->withPivot(['id', 'relationship', 'pickup']);
	}

	public function physicians()
	{
		//withPivot(['id']) returns the selected fields on the pivot table.
        return $this->belongsToMany('App\User', 'child_physicians', 'child_id', 'user_id');
	}

	public function emergencyContacts()
	{
		//withPivot(['id']) returns the selected fields on the pivot table.
        return $this->belongsToMany('App\User', 'child_contacts', 'child_id', 'user_id')->withPivot(['id', 'relationship', 'pickup']);
		//return $this->belongsToMany('App\User');
	}

	public function checkins()
	{
		return $this->hasOne('App\ChildCheckin', 'child_id')
		->where('checked_in', true)
		->where('checked_out', false);	
	}
}
