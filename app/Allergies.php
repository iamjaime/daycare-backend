<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Allergies extends Model {

	protected $table = 'allergies';

	public $create_rules = [
		'childId' => 'required|exists:children,id',
		'to' => 'required',
		'reaction' => 'required'
	];

	public $update_rules = [
		'childId' => 'required|exists:children,id',
		'to' => 'required',
		'reaction' => 'required'
	];

}
