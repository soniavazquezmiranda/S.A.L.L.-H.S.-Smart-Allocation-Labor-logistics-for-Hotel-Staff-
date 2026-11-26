<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
        public function index()
        {
            return view('pda.index');
        }
   
}
