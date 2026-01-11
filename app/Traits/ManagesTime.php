<?php

namespace App\Traits;

trait ManagesTime
{
    /**
     * Get a fresh timestamp for the model.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function freshTimestamp()
    {
        return time_now();
    }
}

