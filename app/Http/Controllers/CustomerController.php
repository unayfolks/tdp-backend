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
        // return response($request);
        DB::beginTransaction();
        try{
            $simpantransaksi = [
                'kode_transaksi' => $request->trx['kode_transaksi'],
                'kode_user' => $request->trx['kode_user'],
                'nama_user' => $request->trx['nama'],
                'tanggal' => $request->trx['tanggal'],
                'jam' => $request->trx['jam'],
                'alamat_kirim' => $request->trx['alamat_kirim'],
                'catatan' => $request->trx['catatan'],
            ];
            DB::table('transaksi_user')->insert($simpantransaksi);
            $item = $request->detail;
            foreach ($item as $dtl) {
                $simpandetail = [
                    'kode_transaksi' => $dtl['kode_transaksi'],
                    'kode_user' => $dtl['kode_user'],
                    'nama_user' => $dtl['nama_user'],
                    'harga' => $dtl['harga'],
                    'subtotal' => $dtl['subtotal'],
                    'jumlah' => $dtl['jumlah'],
                    'pesanan' => $dtl['nama'],
                    'id_pesanan' => $dtl['id_menu'],
                    'nama_perusahaan' => $dtl['nama_perusahaan'],
                    'status' => 'Menunggu pembayaran'
                ];
                DB::table('detail_order')->insert($simpandetail);
            }
        }catch(\Exception $e){
            DB::rollBack();
            $msg = [
                'success' => false,
                'message' => 'Transaksi gagal'
            ];
            return response()->json($msg);
        }
        DB::commit();
        $msg = [
            'success' => true,
            'message' => 'Transaksi berhasill'
        ];
        return response()->json($msg);
    }

    function GetOrder(Request $request, $id) {
        $xyz = DB::table('transaksi_user')
            ->where('kode_user', $id)
            // ->where('status', '=','Proses')
            ->get();

        return response()->json($xyz);
    }
    function GetOrderDetail(Request $request, $id) {
        $qwe = DB::table('detail_order')
            ->where('kode_transaksi', $id)
            
            ->get();
        
        return response()->json($qwe);
    }
    function GetRegency() {
        $regency = DB::table('regencies')
            ->get();
        return response()->json($regency);
    }
    function GetDistrict() {
        $district = DB::table('districts')
            ->get();
        return response()->json($district);
    }
    function AddAlamat(Request $request) {
        $simpanalamat = [
            'kode_customer' => $request->kode_customer,
            'alamat' => $request->alamat,
            'latitude' => $request->lat,
            'longitude' => $request->lng,
            'keterangan' => $request->keterangan,
            'alamat_display' => $request->alamat_display
        ];
        $alamat = DB::table('alamat_kirim_customer')->insert($simpanalamat);

        if ($alamat) {
            return response()->json([
                'success' => true,
                'data' => $alamat,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }
    function GetAlamat(Request $request, $id) {
        $almt = DB::table('alamat_kirim_customer')->where('kode_customer', $id)->get();

        return response()->json($almt);
    }
}
