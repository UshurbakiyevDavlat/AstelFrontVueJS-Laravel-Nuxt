<?php

namespace App\Services\Localization\Models;

use App\Models\Model;
use App\Services\Page\Models\Page;

class Translation extends Model
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'translations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    public $translatable = ['translation'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

        static::creating(function($item) {
            $item->hash = md5($item->getTranslation('translation', 'ru'));
        });

        static::created(function($item) {
            $item->cache();
        });

        static::updated(function($item) {
            $item->cache();
        });

        static::deleted(function($item) {
            $item->removeFromCache();
        });
    }

    public function cache()
    {
        \Cache::put("translation.{$this->hash}", $this->getTranslations('translation'), config('localization.cache_lifetime'));
    }

    public function removeFromCache()
    {
        \Cache::forget("translations.{$this->hash}");
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function pages()
    {
        return $this->belongsToMany(Page::class)->withPivot('level');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
