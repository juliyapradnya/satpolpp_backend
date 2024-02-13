<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Validator;
use App\JenisAduan;

class JenisAduanController extends Controller
{
    //create

    public function store(Request $request){
        
        $storeData = $request->all(); //mengambil input dr klien
        $validate = Validator::make($storeData, [
            
            'keterangan_aduan' => 'required',
            
            
        ]);//membuat rule validasi 
        //isi  jenis aduan

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $jenisaduan = JenisAduan::create($storeData);
        return response([
            'message'=>'Add jenis aduan success',
            'data' => $jenisaduan,
        ],200);//return message jenis aduan kosong
    }
}
