<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function setSmsText(){
        return view('admin.settings.setSmsText');
    }

    public function push_notification(){
        return view('admin.settings.push_notification');
    }
}
