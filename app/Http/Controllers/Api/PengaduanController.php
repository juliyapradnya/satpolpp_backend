<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Pengaduan;
use App\JenisAduan;
use App\Kecamatan;
//use PDF;

class PengaduanController extends Controller
{
    //method tampil data

    public function index(){

         $pengaduans = DB::table('pengaduans')
           -> join('jenis_aduans','jenis_aduans.id','=','pengaduans.id_jenis')
           -> join('kecamatans', 'kecamatans.id', '=', 'pengaduans.id_kecamatan')
           -> select('pengaduans.*','jenis_aduans.keterangan_aduan', 'kecamatans.kecamatan')
           -> get();

        //$pengaduans = Pengaduan::all(); //mengambil semua data

        if(count($pengaduans) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pengaduans
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data' => null
        ],404);//return message Pengaduan kosong
    }

    //method search

    public function show($id){

        // $pengaduan = DB::table('pengaduans')
        //    -> join('jenis_aduans','jenis_aduans.id','=','pengaduans.id_jenis')
        //    -> join('kecamatans', 'kecamatans.id', '=', 'pengaduans.id_kecamatan')
        //    -> select('pengaduans.*','jenis_aduans.keterangan', 'kecamatans.kecamatan')
        //    -> where('pengaduans.id',$id)
        //    -> first();

        $pengaduan = DB::table('view_pengaduan')
           -> where('id',$id)
           -> first();
        // $pengaduan = Pengaduan::find($id); //mencari data

        if(!is_null($pengaduan)){
            return response([
                'message' => 'Retrieve Pengaduan Success',
                'data' => $pengaduan
            ],200);
        }//return data Pengaduan yg ditemukan dlmbentuk json

        return response([
            'message'=>'Pengaduan Not Found',
            'data' => null
        ],404);//return message Pengaduan tidak ditemukan
    }

    //create

    public function store(Request $request){
        
        $storeData = $request->all(); //mengambil input dr klien
        $validate = Validator::make($storeData, [
            
            'nama' => 'required',
            'nik' => 'required|numeric',
            'no_hp' => 'required|numeric|digits_between:10,13|starts_with:08',
            'sasaran' => 'required',
            'waktu' => 'required',
            'tgl_pengaduan' => 'required|date_format:Y-m-d',
            'id_kecamatan' => 'required',
            'id_jenis' => 'required',
            'status' => 'nullable',
            'temuan' => 'nullable',
            'tindakan' => 'nullable',
            'keterangan' => 'nullable',
            'upload_foto' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg',
            
        ]);//membuat rule validasi 
        //isi jenis pengaduan

        // if($validate->fails())
        //     return response(['message' => $validate->errors()],400);

        //     if (!is_null($request->file('upload_foto'))) {
        //         $file          = $request->file('upload_foto');
        //         $nama_file     = time() . "_" . $file->getClientOriginalName();
        //         $tujuan_upload = 'upload_foto';
        //         $file->move($tujuan_upload, $nama_file);
        //     } else {
        //         $nama_file = 'NoImage.png';
        //     }

        // $pengaduan = new Pengaduan();
        
        //  $pengaduan->nama               = $storeData['nama'];
        //  $pengaduan->nik                = $storeData['nik'];
        //  $pengaduan->no_hp              = $storeData['no_hp'];
        //  $pengaduan->sasaran            = $storeData['sasaran'];
        //  $pengaduan->waktu              = $storeData['waktu'];
        //  $pengaduan->tgl_pengaduan      = $storeData['tgl_pengaduan'];
        //  $pengaduan->id_kecamatan       = $storeData['id_kecamatan'];
        //  $pengaduan->id_jenis           = $storeData['id_jenis'];
        //  $pengaduan->status             = $storeData['status'];
        //  $pengaduan->temuan             = $storeData['temuan'];
        //  $pengaduan->tindakan           = $storeData['tindakan'];
        //  $pengaduan->keterangan         = $storeData['keterangan'];
        //  $pengaduan->upload_foto        = $nama_file;

        //  $pengaduan->save();

        // $storeData['upload_foto'] = $nama_file;
        $pengaduan = Pengaduan::create($storeData);
        return response([
            'message'=>'Add Pengaduan success',
            'data' => $pengaduan,
        ],200);//return message Pengaduan kosong
    }
        
    //hapus

    public function destroy($id){
        $pengaduan = Pengaduan::find($id);  //mencari data

        if(is_null($pengaduan)){
            return response([
                'message' => 'Pengaduan Not Found',
                'data' => null
            ],404);
        }

        if($pengaduan->delete()){
            return response([
                'message' => 'Delete Pengaduan Success',
                'data' => $pengaduan,
            ],200);
        }

        return response([
            'message'=>'Delete Pengaduan Failed',
            'data' => null,
        ],400);//return message Pengaduan gagal hapus
    }

    //update

    public function updateVerifikasi(Request $request, $id){
        $pengaduan = Pengaduan::find($id);//cari data
        
        if(is_null($pengaduan)){
            return response([
                'message' => 'Pengaduan Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all(); //mengambil input dr klien
        $validate = Validator::make($updateData, [
            'nama' => '',
            'nik' => 'numeric',
            'no_hp' => 'numeric|digits_between:10,13|starts_with:08',
            'sasaran' => '',
            'waktu' => '',
            'tgl_pengaduan' => 'date_format:Y-m-d',
            'id_kecamatan' => '',
            'id_jenis' => '',
            'status' => '',
            'temuan' => 'nullable',
            'tindakan' => 'nullable',
            'keterangan' => 'nullable',
            'upload_foto' => 'nullable',
            
        ]);//membuat rule validasi
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
         $pengaduan->status = 1 ;//edit 
         $pengaduan->temuan = $updateData['temuan'];//edit nama 
         $pengaduan->tindakan = $updateData['tindakan'];//edit nik
         $pengaduan->keterangan = $updateData['keterangan'];//edit no_hp
        
         if (!is_null($request->file('upload_foto'))) {
            $file          = $request->file('upload_foto');
            $nama_file     = time() . "_" . $file->getClientOriginalName();
            $tujuan_upload = 'upload_foto';
            $file->move($tujuan_upload, $nama_file);

            $pengaduan->upload_foto     = $nama_file;
        } 
        
        if($pengaduan->save()){
            return response([
                'message' => 'Verifikasi Success',
                'data' => $pengaduan,
            ],200);
        }

        return response([
             'message' => 'Verifikasi failed',
             'data' => null,
         ],400);
    }

    public function updatePengaduan(Request $request, $id){
        $pengaduan = Pengaduan::find($id);//cari data
        if(is_null($pengaduan)){
            return response([
                'message' => 'Pengaduan Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all(); //mengambil input dr klien
        $validate = Validator::make($updateData, [
            'nama' => '',
            'nik' => 'numeric',
            'no_hp' => 'numeric|digits_between:10,13|starts_with:08',
            'sasaran' => '',
            'waktu' => '',
            'tgl_pengaduan' => 'date_format:Y-m-d',
            'id_kecamatan' => '',
            'id_jenis' => '',
            'status' => '',
            'temuan' => 'nullable',
            'tindakan' => 'nullable',
            'keterangan' => 'nullable',
            'upload_foto' => 'nullable',
            
        ]);//membuat rule validasi
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
         $pengaduan->nama = $updateData['nama'];//edit nama 
         $pengaduan->nik = $updateData['nik'];//edit nik
         $pengaduan->no_hp = $updateData['no_hp'];//edit no_hp
         $pengaduan->sasaran = $updateData['sasaran'];//edit jenis_aduan
         $pengaduan->waktu = $updateData['waktu'];//edit jam
         $pengaduan->tgl_pengaduan = $updateData['tgl_pengaduan'];//edit tgl_pengaduan
         $pengaduan->id_kecamatan = $updateData['id_kecamatan'];//edit 
         $pengaduan->id_jenis = $updateData['id_jenis'];//edit 
        
        
        if($pengaduan->save()){
            return response([
                'message' => 'Update Pengaduan Success',
                'data' => $pengaduan,
            ],200);
        }

        
        return response([
             'message' => 'Update Pengaduan failed',
             'data' => null,
         ],400);
    }

    //  public function updateStatus (Request $request, $id)
    //  {
    //      $pengaduan = Pengaduan::find($id);
    //      if(is_null($pengaduan)){
    //          return response([
    //              'message' => 'Pengaduan Not Found',
    //              'data' => null
    //          ],404);
    //      }

    //      $updateData = $request->all(); //mengambil semua input dari api client
    //      $validate = Validator::make($updateData, [
            
    //          'status' => 'required',

    //      ]); //membuat rule validasi input


    //      if($validate->fails())
    //          return response(['message' => $validate->errors()],400); //return error invalid input
        
    //      $pengaduan->status = $updateData['status']; //edit status

    //     if($pengaduan->save()){
    //          return response([
    //             'message' => 'Update Status Success',
    //              'data' => $pengaduan,
    //          ],200);
    //      } //return data pesanan yang telah di edit dalam bentuk json

    //      return response([
    //          'message' => 'Update Status Failed',
    //          'data' => null,
    //      ],400); //return message saat pesanan gagal di edit
    //  }
    

    // public function cetak_pdf()
    // {
    //     $pegawai = Pegawai::all();
    
    //     $pdf = PDF::loadview('pegawai_pdf',['pegawai'=>$pegawai]);
    //     return $pdf->download('laporan-pegawai-pdf');
    // }

    public function laporanHarian ($date1,$date2) {
        $pengaduan = DB::table('pengaduans')
           -> join('kecamatans', 'kecamatans.id', '=', 'pengaduans.id_kecamatan')
        //    -> whereDay('pengaduans.tgl_pengaduan', '=', $date)
        //     -> whereMonth('pengaduans.tgl_pengaduan', '=',$month)
        //     -> whereYear('pengaduans.tgl_pengaduan', '=', $year)
           -> where('pengaduans.status','=',1)
           -> whereBetween('pengaduans.tgl_pengaduan',[$date1,$date2])
           -> select(DB::raw('DATE_FORMAT(pengaduans.tgl_pengaduan, "%d %M %Y") as tanggal'),('pengaduans.waktu as pukul'),'pengaduans.sasaran',('kecamatans.kecamatan as lokasi'),'pengaduans.temuan',('pengaduans.tindakan as tindak_lanjut'),'pengaduans.keterangan')
           -> orderBy('tanggal')
           -> get();

           if(!is_null($pengaduan) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pengaduan
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data' => null
        ],404);
    }

    // public function laporanBulanan ($month,$year) {
    //     $pengaduan = DB::table('pengaduans')
    //        -> join('kecamatans', 'kecamatans.id', '=', 'pengaduans.id_kecamatan')
    //        -> whereMonth('pengaduans.tgl_pengaduan', '=',$month)
    //        -> whereYear('pengaduans.tgl_pengaduan', '=', $year)
    //        -> where('pengaduans.status','=',1)
    //        -> select(DB::raw('DATE_FORMAT(pengaduans.tgl_pengaduan, "%d %M %Y") as tanggal'),('pengaduans.waktu as pukul'),'pengaduans.sasaran',('kecamatans.kecamatan as lokasi'),'pengaduans.temuan',('pengaduans.tindakan as tindak lanjut'),'pengaduans.keterangan')
    //        -> orderBy('tanggal')
    //        -> get();

    //        if(!is_null($pengaduan) > 0){
    //         return response([
    //             'message' => 'Retrieve All Success',
    //             'data' => $pengaduan
    //         ],200);
    //     }

    //     return response([
    //         'message'=>'Empty',
    //         'data' => null
    //     ],404);
    // }
}