<?php

namespace Modules\Iplaces\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Laracasts\Presenter\PresentableTrait;

class Schedule extends Model
{
    use Translatable,PresentableTrait, NamespacedEntity;

    protected $table = 'iplaces__schedules';
    public $translatedAttributes = ['title'];
    protected $fillable = ['title'];
    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];
    public function places()
    {
        return $this->hasMany(Place::class);
    }

    /*
 |--------------------------------------------------------------------------
 | SCOPES
 |--------------------------------------------------------------------------
 */
    public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
            ->orWhere('depth', null)
            ->orderBy('lft', 'ASC');
    }

}
