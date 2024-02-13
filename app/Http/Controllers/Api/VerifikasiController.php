<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Verifikasi;
use App\Pengaduan;

class VerifikasiController extends Controller
{
    //method tampil data

    public function index(){
         //mengambil semua data
          
         $verifikasis = DB::table('verifikasis')
           -> join('pengaduans','pengaduans.id','=','verifikasis.id_pengaduan')
           -> select('verifikasis.*','pengaduans.nama')
           -> get();

        //$verifikasis = Verifikasi::all();

        if(count($verifikasis) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $verifikasis
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data' => null
        ],404);//return message Verifikasi kosong
    }

    //method search

    public function show($id){
        $verifikasi = Verifikasi::find($id); //mencari data

        if(!is_null($verifikasi)){
            return response([
                'message' => 'Retrieve Verifikasi Success',
                'data' => $verifikasi
            ],200);
        }//return data Verifikasi yg ditemukan dlmbentuk json

        return response([
            'message'=>'Verifikasi Not Found',
            'data' => null
        ],404);//return message Verifikasi tidak ditemukan
    }

    //create

    public function store(Request $request){
        $storeData = $request->all(); //mengambil input dr klien
        $validate = Validator::make($storeData, [
            'id_pengaduan' => 'required',
            'temuan' => 'required',
            'tindakan' => 'required',
            'keterangan' => 'required',
            'upload_foto' => 'required',
            
        ]);//membuat rule validasi
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        if (!is_null($request->file('upload_foto'))) {
             $file          = $request->file('upload_foto');
             $nama_file     = time() . "_" . $file->getClientOriginalName();
             $tujuan_upload = 'upload_foto';
             $file->move($tujuan_upload, $nama_file);
         } else {
             $nama_file = 'NoImage.png';
         }

         $verifikasi = new Verifikasi();

        //  if($storeData['id'] == ''){
        //      $verifikasi = new Verifikasi();
        //  }else {
        //      $verifikasi = Verifikasi::find($storeData['id']);//cari data
        //  }
        
        // // ($verifikasi == false) ? '' : $verifikasi->id = $storeData['id'];
          $verifikasi->id_pengaduan    = $storeData['id_pengaduan'];
          $verifikasi->temuan          = $storeData['temuan'];
          $verifikasi->tindakan        = $storeData['tindakan'];
          $verifikasi->keterangan      = $storeData['keterangan'];
          $verifikasi->upload_foto     = $nama_file;

          $verifikasi->save();

        // $storeData['upload_foto'] = $nama_file;
        // $verifikasi = Verifikasi::create($storeData);
        return response([
            'message'=>'Add Verifikasi success',
            'data' => $verifikasi,
        ],200);//return message Verifikasi kosong
    }

    //hapus

    public function destroy($id){
        $verifikasi = Verifikasi::find($id);  //mencari data

        if(is_null($verifikasi)){
            return response([
                'message' => 'Verifikasi Not Found',
                'data' => null
            ],404);
        }

        if($verifikasi->delete()){
            return response([
                'message' => 'Delete Verifikasi Success',
                'data' => $verifikasi,
            ],200);
        }

        return response([
            'message'=>'Delete Verifikasi Failed',
            'data' => null,
        ],400);//return message Verifikasi gagal hapus
    }

    //update

    public function update(Request $request, $id){
        $verifikasi = Verifikasi::find($id);//cari data
        
        if(is_null($verifikasi)){
            return response([
                'message' => 'Verifikasi Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all(); //mengambil input dr klien
        $validate = Validator::make($updateData, [
            'id_pengaduan' => '',
            'temuan' => '',
            'tindakan' => '',
            'keterangan' => '',
            'upload_foto' => 'nullable',
            
        ]);//membuat rule validasi
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $verifikasi->id_pengaduan = $updateData['id_pengaduan'];//edit nama 
        $verifikasi->temuan = $updateData['temuan'];//edit nama 
        $verifikasi->tindakan = $updateData['tindakan'];//edit nik
        $verifikasi->keterangan = $updateData['keterangan'];//edit no_hp

        if (!is_null($request->file('upload_foto'))) {
            $file          = $request->file('upload_foto');
            $nama_file     = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'upload_foto';
            $file->move($tujuan_upload, $nama_file);

            $verifikasi->upload_foto     = $nama_file;
        }
        
        
        if($verifikasi->save()){
            return response([
                'message' => 'Update Verifikasi Success',
                'data' => $verifikasi,
            ],200);
        }

        
        return response([
            'message' => 'Update Verifikasi failed',
            'data' => null,
        ],400);
    }
}