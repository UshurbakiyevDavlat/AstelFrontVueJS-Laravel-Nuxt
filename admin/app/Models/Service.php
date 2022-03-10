<?php

namespace App\Models;

use App\Common\Concerns\SluggableTrait;
use App\Common\Contracts\Sluggable;

use App\Services\Elasticsearch\Contracts\Searchable;
use App\Services\Elasticsearch\Concerns\Searchable as SearchableTrait;

use App\Common\Concerns\HasSeoTags;

class Service extends Model implements Sluggable, Searchable
{
    use SluggableTrait;
    use SearchableTrait;
    use HasSeoTags;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'services';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    public $translatable = ['name', 'content', 'seo', 'data','docs'];
    protected $fakeColumns = ['seo', 'data','docs'];
    public $full_slug = null;
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
            'image' => elfinder($this->image),
            'slug' => $this->getFullSlug(),
            'serviceImages'=>$this->getDocs('ImageForServices'),
        ];
    }

    public function breadcrumbs() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->getFullSlug(),
            'breadcrumbs' => $this->parentService ? $this->parentService->breadcrumbs() : null
        ];
    }

    public function toElastic() : array
    {
        return [
            'name' => implodeToString($this->getTranslations('name')),
            'slug' => $this->slug,
            'seo' => implodeToString($this->getTranslations('seo')),
            'data' => implodeToString($this->getTranslations('data')),
            'content' => implodeToString($this->getTranslations('content')),
            'docs' => implodeToString($this->getTranslations('docs')),
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function parentService()
    {
        return $this->belongsTo(static::class, 'parent_id')->where('id', '<>', $this->id);
    }

    public function childServices()
    {
        return $this->hasMany(static::class, 'parent_id')->where('id', '<>', $this->id);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeMain($query)
    {
        $query->active()->where('parent_id', null)->orderBy('lft');
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

    public function getDocs(string $field = null)
    {
        return $field ? optional($this->decoded('docs'))->{$field} : $this->decoded_data;
    }

    public function getFullSlug($rec = false) : string
    {
        if (!$this->full_slug) {
            $slug = $this->slug;
            if (!$rec && in_array($this->id, [2, 16, 20, 27, 32, 31, 35]) && $first_child = $this->childServices()->active()->orderBy('lft')->first()) {
                $slug.= "/{$first_child->slug}";
            }
            $this->full_slug = implode('/', array_filter([$this->parentService ? $this->parentService->getFullSlug(true) : null, $slug]));
        }

        return $this->full_slug;
    }

    public function getElasticTitle() : string
    {
        return $this->name;
    }

    public function getElasticDescription() : string
    {
        return stripAndLimit($this->content);
    }

    public function getElasticTemplate()
    {
        return 'services';
    }

    public function getElasticSlug()
    {
        return $this->getFullSlug();
    }

    public static function getIcons() : array
    {
        $files = \Storage::disk('elfinder')->files('icons');
        $icons = [];
        foreach($files as $file) {
            $name = "/elfinder/{$file}";
            $icons[$name] = "<i class='svg-icon'><img src=\"/storage/{$name}\"></i>";
        }

        return $icons;
    }

    public function getSeoTags() : array
    {
        $seo = $this->decoded('seo');

        return [
            'seo_title' => $seo->seo_title ?? $this->name,
            'seo_keywords' => $seo->seo_keywords ?? null,
            'seo_description' => $seo->seo_description ?? stripAndLimit($this->content),
            'seo_image' => elfinder($seo->seo_image ?? null),
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
