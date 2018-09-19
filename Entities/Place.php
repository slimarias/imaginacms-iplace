<?php

namespace Modules\Iplaces\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use Translatable;

    protected $table = 'iplaces__places';
    public $translatedAttributes = [];
    protected $fillable = [];
}
