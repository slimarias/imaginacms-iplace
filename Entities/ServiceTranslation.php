<?php

namespace Modules\Iplaces\Entities;

use Illuminate\Database\Eloquent\Model;

class ServiceTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title','description','slug','metatitle','metadescription','metakeywords'];
    protected $table = 'iplaces__service_translations';


    protected function setSummaryAttribute($value){

        if(!empty($value)){
            $this->attributes['summary'] = $value;
        } else {
            $this->attributes['summary'] = substr(strip_tags($this->attributes['description']),0,150);
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
