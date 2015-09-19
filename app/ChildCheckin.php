<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildCheckin extends Model {

	public $timestamps = false;
	//

	public $create_rules = [
		'childId' => 'required|exists:children,id'
	];

	public $update_rules = [
		'childId' => 'required|exists:children,id'
	];
}
