<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {

	public $create_rules = [
		'staff_id' => 'required|exists:users,id',
		'child_id' => 'required|exists:children,id', 
		'title' => 'required',
		'note' => 'required'
	];

	public $update_rules = [
		'staff_id' => 'required|exists:users,id',
		'child_id' => 'required|exists:children,id', 
		'title' => 'required',
		'note' => 'required'
	];

}
