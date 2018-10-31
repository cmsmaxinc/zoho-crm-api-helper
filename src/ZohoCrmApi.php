<?php

namespace Cmsmax\ZohoCrmApiHelper\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade
{
    protected static function getFacadeAccessor()
    {
        return "zoho_crm_api";
    }
}
