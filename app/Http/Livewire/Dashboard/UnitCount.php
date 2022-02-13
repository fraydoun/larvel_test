<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Unit;
use Livewire\Component;

class UnitCount extends Component
{
    public function render()
    {
        $unitCount = Unit::count();
        return view('livewire.dashboard.unit-count', compact('unitCount'));
    }
}
