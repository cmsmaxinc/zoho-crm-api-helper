<?php

namespace Cmsmax\ZohoCrmApiHelper\Models;

use Illuminate\Database\Eloquent\Model;

class ZohoToken extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'zoho_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'value',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

    public static function getAccessToken()
    {
        return static::where('type', 'access')->latest()->first();
    }

    public static function getRefreshToken()
    {
        return static::where('type', 'refresh')->latest()->first();
    }

    public function updateAccessToken($newToken)
    {
        $this->value = $newToken->access_token;
        $this->expires_at = now()->addSeconds($newToken->expires_in_sec);
        $this->save();
    }

    public function updateRefreshToken($newToken)
    {
        $this->value = $newToken->refresh_token;
        $this->save();
    }

    public function expired()
    {
        return now()->gte($this->expires_at);
    }
}
