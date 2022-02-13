<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;

class UserCounts extends Component
{
    public function render()
    {
        $userCount = User::count();
        return view('livewire.dashboard.user-counts', compact('userCount'));
    }
}
