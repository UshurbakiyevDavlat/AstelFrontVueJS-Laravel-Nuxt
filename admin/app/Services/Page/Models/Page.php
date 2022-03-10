<?php

namespace App\Services\Page\Models;

use App\Models\Model;
use App\Services\Page\Concerns\HasTemplate;

use App\Common\Contracts\Sluggable;
use App\Common\Concerns\SluggableTrait;
use App\Services\Localization\Models\Translation;

use App\Common\Concerns\HasSeoTags;

class Page extends Model implements Sluggable
{
    use HasTemplate;
    use SluggableTrait;
    use HasSeoTags;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public $translatable = ['name', 'data', 'seo'];
    protected $fakeColumns = ['data', 'seo'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function simple() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->template == 'home' ? '' : $this->slug,
            'template' => $this->template,
            'title' => $this->getData('title') ?? $this->name,
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function childPages()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function parentPage()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function translations()
    {
        return $this->belongsToMany(Translation::class)->withPivot('level');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeSimple($query)
    {
        return $query->select('id', 'name', 'template', 'slug', 'parent_id', 'lft');
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getData(string $field = null)
    {
        return $field ? optional($this->decoded('data'))->{$field} : $this->decoded_data;
    }

    public function getSeoTags() : array
    {
        $seo = $this->decoded('seo');

        return [
            'seo_title' => $seo->seo_title ?? $this->name,
            'seo_keywords' => $seo->seo_keywords ?? null,
            'seo_description' => $seo->seo_description ?? null,
            'seo_image' => elfinder($seo->seo_image ?? null),
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
