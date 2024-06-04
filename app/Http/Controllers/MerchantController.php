<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MerchantController extends Controller
{
    function UpdateProfil(Request $request, $id)
    {
        $profile = DB::table('users')->where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'nohp' => $request->nohp,
                'nama_perusahaan' => $request->nama_perusahaan,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi

            ]);
        return response()->json($profile);
    }
}
