<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
        public function index()
        {
            return view('gobernanta.index');
        }
}
