<?php

namespace Modules\Iplaces\Entities;


class Weather
{
    const CLOUDY = 0;
    const WARM = 1;

    private $weathers=[];

    public function __construct()
    {
        $this->weathers = [
            self::CLOUDY => trans('iplaces::status.cloudy'),
            self::WARM => trans('iplaces::status.warm'),

        ];
    }

    public function lists()
    {
        return $this->weathers;
    }
    public function get($weatherId)
    {
        if (isset($this->weathers[$weatherId])) {
            return $this->weathers[$weatherId];
        }

        return $this->weathers[self::WARM];
    }

}