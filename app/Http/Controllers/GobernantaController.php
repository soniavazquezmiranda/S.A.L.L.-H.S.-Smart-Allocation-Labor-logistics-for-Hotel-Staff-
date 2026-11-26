<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Task;
use Illuminate\Http\Request;

class GobernantaController extends Controller
{
        public function index()
        {
            return view('gobernanta.index');
        }
     
}
