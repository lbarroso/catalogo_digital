<?php

namespace App\Observers;

use App\Jobs\CreateAnimalJob;
use App\Models\Figure;

class FigureObserve
{
    /**
     * Handle the Figure "created" event.
     *
     * @param  \App\Models\Figure  $figure
     * @return void
     */
    public function created(Figure $figure)
    {
        CreateAnimalJob::dispatch();
    }

    /**
     * Handle the Figure "updated" event.
     *
     * @param  \App\Models\Figure  $figure
     * @return void
     */
    public function updated(Figure $figure)
    {
        //
    }

    /**
     * Handle the Figure "deleted" event.
     *
     * @param  \App\Models\Figure  $figure
     * @return void
     */
    public function deleted(Figure $figure)
    {
        //
    }

    /**
     * Handle the Figure "restored" event.
     *
     * @param  \App\Models\Figure  $figure
     * @return void
     */
    public function restored(Figure $figure)
    {
        //
    }

    /**
     * Handle the Figure "force deleted" event.
     *
     * @param  \App\Models\Figure  $figure
     * @return void
     */
    public function forceDeleted(Figure $figure)
    {
        
    }
}
