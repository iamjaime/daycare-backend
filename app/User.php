<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 
        'address', 
        'city', 
        'province', 
        'postal_code',
        'primary_phone',
        'alternate_phone',
        'work_phone', 
        'status', 
        'email', 
        'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public $signin_rules = [
        'email' => 'required|exists:users,email',
        'password' => 'required'
    ];

    public $getFacilitiesRules = [
        'userId' => 'required|exists:users,id'
    ];

    public $create_rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'province' => 'required',
        'postal_code' => 'required',
        'primary_phone' => 'required',
        'role' => 'required',
        'status' => 'required',
        'email' => 'required_if:role,admin,role,parent,role,staff|email|unique:users', //required if not emergency_contact
        'password' => 'required_if:role,admin,role,parent,role,staff|min:8' //required if not emergency contact
    ];

    public $attachParentRules = [
        'parentIds' => 'required|array',
        'childrenIds' => 'required|array'
    ];

    public function facilites()
    {
        return $this->hasMany('facilites');
    }

    /**
     * roles Handles different the pivot table relationship for user roles.
     * @return void
     */
    public function roles()
    {
        //withPivot(['id']) returns the selected fields on the pivot table.
        return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id')
        ->withPivot(['id', 'facility_id']);
    }

    /**
     * children Handles the pivot table relationship for children. (a user has many children)
     * @return void
     */
    public function children()
    {
        //withPivot(['id']) returns the selected fields on the pivot table.
        return $this->belongsToMany('App\Children', 'child_parent', 'user_id', 'child_id')->withPivot(['id']);
      //return $this->belongsToMany('App\Children');
    }

    /**
     * emergencyContacts Handles the pivot table relationship for emergency contacts.
     * @return void
     */
    public function emergencyContacts()
    {
        return $this->belongsToMany('App\Children');
    }

    /**
     * updateRules Handles the update record rules
     * @param  int  $id    The record ID to ignore
     * @return array       The update rules
     */
    public function updateRules($id){
         return $this->update_rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'province' => 'required',
                'postal_code' => 'required',
                'primary_phone' => 'required',
                'role' => 'required',
                'status' => 'sometimes|required',
                'email' => 'sometimes|required_if:role,admin,role,parent,role,staff|email|unique:users,email,' . $id,
                'password' => 'sometimes|required_if:role,admin,role,parent,role,staff|min:8'
            ];
    }
}
