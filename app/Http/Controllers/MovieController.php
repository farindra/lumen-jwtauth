<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function all(){
        
        return $this->core->setResponse('success', 'Get Movies', Movie::all());
    }
}
