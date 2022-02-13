<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Building;
use Livewire\Component;

class BuildingsCounts extends Component
{
    public function render()
    {
        $buildingCount = Building::count();
        return view('livewire.dashboard.buildings-counts', compact('buildingCount'));
    }
}
