<?php

namespace Cmsmax\ZohoCrmApiHelper;

use Cmsmax\ZohoCrmApiHelper\Models\ZohoToken;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    public function register()
    {
        $this->app->singleton("zoho_crm_api", function ($app) {
            $clientId = config('services.zoho_crm_api.client_id');
            $clientSecret = config('services.zoho_crm_api.client_secret');
            $accessToken = ZohoToken::getAccessToken();
            $refreshToken = ZohoToken::getRefreshToken();

            return new ZohoCrmApiClientHelper(
                $clientId,
                $clientSecret,
                $accessToken,
                $refreshToken
            );
        });
    }
}
