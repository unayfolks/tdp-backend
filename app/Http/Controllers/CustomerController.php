<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    function GetMenu()
    {
        $menu = DB::table('menu_merchant')
            ->join('users', 'menu_merchant.kode_merchant', '=', 'users.id')
            ->select('menu_merchant.*', 'users.nama_perusahaan', 'users.name')
            ->get();
        return response()->json($menu);
    }
    function AddTrx(Request $request) {
        return response($request);
    }
}
