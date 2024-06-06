<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    function GetMenu(){
        $qwe = DB::table('menu_merchant')->get();

        return response()->json($qwe);
    }
}
