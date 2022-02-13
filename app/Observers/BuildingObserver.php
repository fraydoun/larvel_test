<?php

namespace App\Observers;

use App\Models\Building;

class BuildingObserver
{
    /**
     * Handle the Building "created" event.
     *
     * @param  \App\Models\Building  $building
     * @return void
     */
    public function created(Building $building)
    {
        //
    }

    /**
     * Handle the Building "updated" event.
     *
     * @param  \App\Models\Building  $building
     * @return void
     */
    public function updated(Building $building)
    {
        //
    }

    /**
     * Handle the Building "deleted" event.
     *
     * @param  \App\Models\Building  $building
     * @return void
     */
    public function deleted(Building $building)
    {
        $units = $building->relUnits;

        // becuse fire event delete for unit . use loop and call delete on model statement.
        foreach($units as $unit){
            $unit->delete();
        }
    }

    /**
     * Handle the Building "restored" event.
     *
     * @param  \App\Models\Building  $building
     * @return void
     */
    public function restored(Building $building)
    {
        //
    }

    /**
     * Handle the Building "force deleted" event.
     *
     * @param  \App\Models\Building  $building
     * @return void
     */
    public function forceDeleted(Building $building)
    {
        //
    }
}
