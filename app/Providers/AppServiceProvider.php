<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Relation::morphMap([
            'approve'   => 'App\Models\Role',
            'create'    => 'App\Models\RoleDocTypeCreator',
            'employee'  => 'App\Models\Employee',
            'applicant' => 'App\Models\JobApplicant',
            'team'      => 'App\Models\Team',
            'user'      => 'App\Models\User',
            'blog_post' => 'App\Models\BlogPost',
            'reward'    => 'App\Models\Reward',
        ]);
    }
}
