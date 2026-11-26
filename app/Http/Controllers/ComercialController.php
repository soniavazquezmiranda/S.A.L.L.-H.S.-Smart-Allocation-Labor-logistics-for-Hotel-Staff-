<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use App\Models\Task;
use Illuminate\Http\Request;

class ComercialController extends Controller
{
  
    public function index()
        {
            return view('comercial.index');
        }

}
