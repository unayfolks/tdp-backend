<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

    function AddMenu(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kode_merchant' => 'required|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/fotos');
            $foto = basename($path);
        } else {
            $foto = null;
        }

        $menuId = DB::table('menu_merchant')->insertGetId([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'kode_merchant' => $request->kode_merchant,

        ]);

        $menu = DB::table('menu_merchant')->where('id', $menuId)->first();

        return response()->json([
            'message' => 'Menu berhasil ditambahkan',
            'menu' => $menu,
            'foto_url' => asset('storage/fotos/' . $foto)
        ], 201);
    }
    function UpdateMenu(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kode_merchant' => 'required|integer',
        ]);

        $menu = DB::table('menu_merchant')->where('id', $id)->first();
        if (!$menu) {
            return response()->json(['message' => 'Menu tidak ditemukan'], 404);
        }

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::delete('public/fotos/' . $menu->foto);
            }
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/fotos', $imageName);
        } else {
            $imageName = $menu->foto;
        }

        DB::table('menu_merchant')
            ->where('id', $id)
            ->update([
                'nama' => $validatedData['nama'],
                'harga' => $validatedData['harga'],
                'deskripsi' => $validatedData['deskripsi'],
                'foto' => $imageName,
                'kode_merchant' => $validatedData['kode_merchant'],
            ]);

        return response()->json(['message' => 'Menu berhasil diperbarui']);
    }
    function GetMenu(Request $request, $id)
    {
        $asd = DB::table('menu_merchant')->where('kode_merchant', $id)->get();

        return response()->json($asd);
    }

}
