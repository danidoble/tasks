<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
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
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'projects:read',
            'projects:create',
            'projects:update',
            'projects:delete',

            'tasks:read',
            'tasks:create',
            'tasks:update',
            'tasks:delete',

            'shared-projects:read',
            'shared-projects:create',
            'shared-projects:update',
            'shared-projects:delete',

            'shared-tasks:read',
            'shared-tasks:create',
            'shared-tasks:update',
            'shared-tasks:delete',
        ]);
    }
}
