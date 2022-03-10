<?php

namespace App\Models;

use App\Common\Concerns\SluggableTrait;
use App\Common\Contracts\Sluggable;

use App\Services\Elasticsearch\Contracts\Searchable;
use App\Services\Elasticsearch\Concerns\Searchable as SearchableTrait;

use App\Common\Concerns\HasSeoTags;

class Project extends Model implements Sluggable, Searchable
{
    use SluggableTrait;
    use SearchableTrait;
    use HasSeoTags;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'projects';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $dates = [
        'published_at'
    ];
    public $translatable = ['name', 'labels', 'content', 'description', 'consultation', 'seo'];
    protected $fakeColumns = ['seo'];
    public $casts = [
        'images' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

        static::creating(function($project) {
            if ($project->status == PUBLISHED && !$project->published_at) {
                $project->published_at = now();
            }
        });

        static::updating(function($project) {
            if ($project->isDirty('status') && $project->status == PUBLISHED && !$project->published_at) {
                $project->published_at = now();
            }
        });
    }

    public function simple() : array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description ? $this->description : $this->getDescriptionFromContent(),
            'image' => elfinder($this->image),
        ];
    }

    public function toElastic() : array
    {
        return [
            'name' => implodeToString($this->getTranslations('name')),
            'slug' => $this->slug,
            'description' => implodeToString($this->getTranslations('description')),
            'seo' => implodeToString($this->getTranslations('seo')),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopePublished($query)
    {
        $query->active()->where('published_at', '<=', now())->orderBy('lft');
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getDescriptionFromContent()
    {
        return stripAndLimit($this->content);
    }

    public function getElasticTitle() : string
    {
        return $this->name;
    }

    public function getElasticDescription() : string
    {
        return $this->description ? $this->description : $this->getDescriptionFromContent();
    }

    public function getElasticTemplate()
    {
        return 'projects';
    }

    public function getSeoTags() : array
    {
        $seo = $this->decoded('seo');

        return [
            'seo_title' => $seo->seo_title ?? $this->name,
            'seo_keywords' => $seo->seo_keywords ?? null,
            'seo_description' => $seo->seo_description ?? ($this->description ? $this->description : $this->getDescriptionFromContent()),
            'seo_image' => elfinder($seo->seo_image ?? $this->image),
        ];
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
