<?php

namespace App\Http\Livewire\Building;

use App\Models\Building;
use Livewire\Component;
use Livewire\WithPagination;

class ListBuilding extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.building.list-building',[
            'buildings' => Building::paginate(10)
        ]);
    }
}
