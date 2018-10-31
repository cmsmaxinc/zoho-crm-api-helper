<?php

namespace Cmsmax\ZohoCrmApiHelper\Facades;

use Illuminate\Support\Facades\Facade;

class ZohoCrmApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "zoho_crm_api";
    }
}
