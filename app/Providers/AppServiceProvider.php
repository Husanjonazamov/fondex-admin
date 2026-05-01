<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        setcookie('XSRF-TOKEN-AK', bin2hex(config('services.firebase.api_key')), time() + 3600, "/");
        setcookie('XSRF-TOKEN-AD', bin2hex(config('services.firebase.auth_domain')), time() + 3600, "/");
        setcookie('XSRF-TOKEN-DU', bin2hex(config('services.firebase.database_url')), time() + 3600, "/");
        setcookie('XSRF-TOKEN-PI', bin2hex(config('services.firebase.project_id')), time() + 3600, "/");
        setcookie('XSRF-TOKEN-SB', bin2hex(config('services.firebase.storage_bucket')), time() + 3600, "/");
        setcookie('XSRF-TOKEN-MS', bin2hex(config('services.firebase.messaging_sender_id')), time() + 3600, "/");
        setcookie('XSRF-TOKEN-AI', bin2hex(config('services.firebase.app_id')), time() + 3600, "/");
        setcookie('XSRF-TOKEN-MI', bin2hex(config('services.firebase.measurement_id')), time() + 3600, "/");

        $countries_data = [];
        $get_countries_json = file_get_contents(public_path('countriesdata.json'));
        if ($get_countries_json != '') {
            $countries_data = json_decode($get_countries_json);
        }
        view()->composer('*', function ($view) use ($countries_data) {
            $view->with('countries_data', $countries_data);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
