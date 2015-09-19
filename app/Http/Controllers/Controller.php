<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \Request;
use App\Facility;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
	 * getFacility Get the authorized facility
	 * @return int  The facility id
	 */
	public function getFacility(){
		$token = Request::header('X-Auth-Token');
		$facility = Facility::where('api_auth_token', $token)->first();
		if($facility){
			return $facility->id;
		}
		return false;
	}
}
