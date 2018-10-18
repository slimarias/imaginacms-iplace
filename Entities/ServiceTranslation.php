<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description','slug','metatitle','metadescription','metakeywords'];
    protected $table = 'iplaces__service_translations';
}
