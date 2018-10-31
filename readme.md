# Zoho CRM API Helper
This package helps make it a little easier to use the Cmsmax\ZohoCrmAPI package by providing a facade and a helper client that automatically takes care of retrieving, saving and refreshing tokens.

## Installation
```
composer require cmsmax/zoho-crm-api-helper
```
Publish the migrations
```
php artisan vendor:publish
```
Then, choose ` Cmsmax\ZohoCrmApiHelper\ServiceProvider` from the list.

Add the following to your `config/services.php` file.
```
'zoho_crm_api' => [
    'client_id' => env('ZOHO_CRM_API_CLIENT_ID', ''),
    'client_secret' => env('ZOHO_CRM_API_CLIENT_SECRET', ''),
],
```
Set your environment variables in your `.env` file.
```
ZOHO_CRM_API_CLIENT_ID=your_client_id
ZOHO_CRM_API_CLIENT_SECRET=your_client_secret
```
Finally, run the migrations.
```
php artisan migrate
```

## Usage
First, you'll need to authorize your app.
```php
ZohoCrmApi::getTokens($grantToken, $redirectUri);
```
This will get the tokens from Zoho and save them in you `zoho_tokens` table.

Now you can run your API queries.
```
$request = new \Cmsmax\ZohoCrmApi\Request;
$request->settings->modules->get();

$response = ZohoCrmApi::send($request);
```
