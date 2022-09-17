<?php

namespace App;

use App\Observers\UserTrackerObserver;

trait ObservantTrait
{
    public static function bootObservantTrait()
    {
        static::observe(new UserTrackerObserver);
    }
}
