<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Centre_Point;
use App\Models\Spot;


class MapController extends Controller
{
    public function index(){
        $data = Spot::all(); 
        return view("leaflet.home", compact('data'));
    }
}

?>