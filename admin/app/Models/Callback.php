<?php

namespace App\Models;

use App\Mail\ServiceCallbackMail;
use App\Mail\CallbackMail;
use App\Mail\PartnershipMail;
use App\Services\Settings\Models\Settings;

class Callback extends Model
{
    use \App\Common\Concerns\SendsMail;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'callbacks';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeServiceCallback($query)
    {
        $query->where('service_id', '<>', null);
    }

    public function scopeNotServicecallback($query)
    {
        $query->where('service_id', null);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getNotificationMail()
    {
        if ($this->service_id) {
            return new ServiceCallbackMail($this);
        }
        return $this->is_partnership ? new PartnershipMail($this) : new CallbackMail($this);
    }

    public function getAddress() : string
    {
        if ($this->service_id) {
            return Settings::where('key', 'servicecallback_mail')->first()->value ?? '';
        }
        return Settings::where('key', $this->is_partnership ? 'partnership_mail' : 'callback_mail')->first()->value ?? '';
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
