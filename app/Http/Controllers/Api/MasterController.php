<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Validator;
use App\JenisAduan;
use App\Kecamatan;


class MasterController extends Controller
{
    public function readJenisAduan(){
        //mengambil semua data

       $jenisaduan = JenisAduan::all();

       if(count($jenisaduan) > 0){
           return response([
               'message' => 'Retrieve All Success',
               'data' => $jenisaduan
           ],200);
       }

       return response([
           'message'=>'Empty',
           'data' => null
       ],404);//return message jenis aduan kosong
   }

   public function readKecamatan(){
    //mengambil semua data

   $kecamatan = Kecamatan::all();

   if(count($kecamatan) > 0){
       return response([
           'message' => 'Retrieve All Success',
           'data' => $kecamatan
       ],200);
   }

   return response([
       'message'=>'Empty',
       'data' => null
   ],404);//return message kecamatan kosong
}

// public function store(Request $request){
        
//     $storeData = $request->all(); //mengambil input dr klien
//     $validate = Validator::make($storeData, [
        
//         'kecamatan' => 'required',
        
        
//     ]);//membuat rule validasi 
//     //isi jenis kecamatan

//     if($validate->fails())
//         return response(['message' => $validate->errors()],400);

    
//     $kecamatan = Kecamatan::create($storeData);
//     return response([
//         'message'=>'Add kecamatan success',
//         'data' => $kecamatan,
//     ],200);//return message kecamatan kosong
// }


}
