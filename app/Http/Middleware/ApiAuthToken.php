<?php namespace App\Http\Middleware;

use Closure;

use App\Facility;
use \Response;

class ApiAuthToken {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$payload = $request->header('X-Auth-Token');
	    $facility = Facility::where('api_auth_token', $payload)->first();

	    if(!$payload || !$facility) {

	        $response = Response::json([
	            'error' => true,
	            'message' => 'Not authenticated',
	            'code' => 401],
	            401
	        );

	        $response->header('Content-Type', 'application/json');
	    
	    	return $response;
		}

		return $next($request);
	}
}
