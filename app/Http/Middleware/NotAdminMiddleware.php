<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class NotAdminMiddleware {
	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param Guard $auth
	 *
	 * @return void
	 */
	public function __construct( Guard $auth ) {
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {
		if ($this->auth->getUser()->isAdmin()) {
			return redirect()->home();
		}

		return $next($request);
	}
}
