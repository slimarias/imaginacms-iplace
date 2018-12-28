<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class PlaceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','summary','description','slug','metatitle','metadescription','metakeywords'];
    protected $table = 'iplaces__place_translations';

    protected function setDescriptionAttribute($value){

        $this->attributes['description'] = $value;

        if(!empty($this->attributes['summary'])){
            $this->attributes['summary'] = $this->attributes['summary'];
        } else {
            $this->attributes['summary'] = isubstr(strip_tags($this->attributes['description']),150);
        }

    }

    protected function setMetatitleAttribute($value){

        if(!empty($value)){
            $this->attributes['metatitle'] = $value;
        } else {
            $this->attributes['metatitle'] = $this->attributes['title'];
        }

    }

    protected function setMetadescriptionAttribute($value){

        if(!empty($value)){
            $this->attributes['metadescription'] = $value;
        } else {
            $this->attributes['metadescription'] = substr(strip_tags($this->attributes['description']),0,150);
        }

    }
}
