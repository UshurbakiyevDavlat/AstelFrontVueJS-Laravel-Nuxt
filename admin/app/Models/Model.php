<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Backpack\CRUD\app\Models\Traits\CrudTrait;

use App\Common\Contracts\Translatable;
use App\Common\Concerns\TranslatableTrait;

use App\Common\Contracts\Publishable;
use App\Common\Concerns\PublishableTrait;

class Model extends EloquentModel implements Translatable, Publishable
{
    use HasFactory;
    use CrudTrait;
    use TranslatableTrait;
    use PublishableTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $decoded_data = [];
    protected $guarded = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function decoded(string $field)
    {
        if (!isset($this->decoded_data[$field])) {
            $this->decoded_data[$field] = json_decode_recursive($this->{$field} ?? "{}");
        }
        return $this->decoded_data[$field];
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
