<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecepcionController extends Controller
{
       public function index()
        {
            return view('recepcion.index');
        }
}
