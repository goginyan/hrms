<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Models\Document' => 'App\Policies\DocumentPolicy',
		'App\Models\Event'    => 'App\Policies\EventPolicy',
		'App\Models\Task'     => 'App\Policies\TaskPolicy',
		'App\Models\Team'     => 'App\Policies\TeamPolicy',
		'App\Models\TimeOff'  => 'App\Policies\TimeOffPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();

		// Implicitly grant "Super Admin" role all permissions
		// This works in the app by using gate-related functions like auth()->user->can() and @can()
		//  Gate::before(function( $user, $ability ) {
		//  	return $user->isAdmin() ? true : null;
		//  });
	}
}
