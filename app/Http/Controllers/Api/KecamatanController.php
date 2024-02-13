<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Kecamatan;

class KecamatanController extends Controller
{
    public function store(Request $request){
        
        $storeData = $request->all(); //mengambil input dr klien
        $validate = Validator::make($storeData, [
            
            'kecamatan' => 'required',
            
            
        ]);//membuat rule validasi 
        //isi  kecamatan

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $kecamatan = Kecamatan::create($storeData);
        return response([
            'message'=>'Add kecamatan success',
            'data' => $kecamatan,
        ],200);//return message kecamatan kosong
    }
}
