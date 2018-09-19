<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class PlaceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    protected $table = 'iplaces__place_translations';
}
