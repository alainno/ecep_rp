<?php namespace Ecep\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->bind(
            'Ecep\Helpers\PersonalHelper'
        );
    }

}
