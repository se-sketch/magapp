<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Nomenclature' => 'App\Policies\NomenclaturePolicy',
        'App\Models\Image' => 'App\Policies\ImagePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $arr_users_adm = [
            'thetestproton@protonmail.com',
        ];


        Gate::define('nomenclature-settings', function ($user) use ($arr_users_adm) {
            if (!$user->status){
                //return false;
            }

            if (in_array($user->email, $arr_users_adm)){
                return true;
            }

            return false;
        });

        Gate::define('image-settings', function ($user) use ($arr_users_adm) {
            if (!$user->status){
                //return false;
            }

            if (in_array($user->email, $arr_users_adm)){
                return true;
            }

            return false;
        });


    }
}
