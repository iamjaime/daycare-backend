<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	
	public $timestamps = false;

	/**
	 * users Handles the pivot table relationship for roles. (a user has many roles)
	 * @return void
	 */
	public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
