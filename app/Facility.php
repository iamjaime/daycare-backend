<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model {

	protected $table = 'facilities';

	protected $fillable = [
		'user_id', 
		'name', 
		'address', 
		'city', 
		'province', 
		'postal_code', 
		'primary_phone',
		'fax',
		'logo_url',
		'api_auth_token'
	];

	public $create_rules = [
		'user_id' => 'required|exists:users,id',
		'name' => 'required|unique:clients',
		'address' => 'required',
		'city' => 'required',
		'province' => 'required',
		'postal_code' => 'required',
		'primary_phone' => 'required',
		'fax' => 'sometimes|required',
		'logo_url' => 'sometimes|required'
	];

	/**
	 * updateRules Handles The Update Record Rules
	 * @param  int $id     The ID to ignore uniqueness for
	 * @return array       The array of validation rules
	 */
	public function updateRules($id){
		return $this->update_rules = [
			'user_id' => 'required|exists:users,id',
			'name' => 'required|unique:clients,name,' . $id,
			'address' => 'required',
			'city' => 'required',
			'province' => 'required',
			'postal_code' => 'required',
			'primary_phone' => 'required',
			'fax' => 'sometimes|required',
			'logo_url' => 'sometimes|required'
		];
	}
}
