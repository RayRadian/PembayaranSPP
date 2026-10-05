<?php

namespace App\Http\Controllers;

use App\siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // $data = siswa::orderBy('nomor_induk', 'desc')->paginate(5);
       // return view('siswa/index')->with('data', $data); 

           $search = $request->search;
       
           $data = Siswa::when($search, function ($query, $search) {
                       return $query->where('nama', 'like', "%{$search}%")
                                    ->orWhere('nomor_induk', 'like', "%{$search}%");
                   })
                   ->orderBy('nomor_induk', 'desc')
                   ->paginate(10)
                   ->withQueryString(); // agar paginasi tetap bawa query 'search'
       
           //$error = null;
           //if ($search && $data->isEmpty()) {
           //$error='Data tidak ditemukan';
           //}

           if ($search && $data->isEmpty()) {
           return redirect()->back()->with('error', 'Data tidak ditemukan');
           }

           return view('siswa.index', compact('data'));
       
       
        //$search = $request->input('search');
    
        //$data = Siswa::query()
        //    ->when($search, function($query, $search) {
        //        return $query->where('nama', 'like', "%{$search}%")
        //                     ->orWhere('nomor_induk', 'like', "%{$search}%");
        //   })
            //->get();
        //    ->paginate(5);
    
        //return view('siswa/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('siswa/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // Session::flash('nomor_induk', $request->nomor_induk);
        // Session::flash('nama', $request->nama);
        // Session::flash('alamat', $request->alamat);

        $request->validate([
        'nomor_induk' => 'required|numeric',
        'nama' => 'required',
        'ttl' => 'required',
        'alamat' => 'required',
        'foto' => 'required|mimes:jpeg,jpg,png,gif'
        ],[
         'nomor_induk.required' => 'Nomor induk wajib diisi',
         'nomor_induk.numeric' => 'Nomor induk harus angka',
         'nama.required' => 'Nama wajib diisi',
         'ttl' => 'Tempat & Tanggal Lahir wajib diisi',
         'alamat.required' => 'Alamat wajib diisi',
         'foto.required' => 'Foto harus ada',
         'foto.mimes' => 'Foto hanya boleh ekstensi JPEG, JPG, PNG dan GIF'
        ]);


        $foto_file = $request->file('foto');
        $foto_ekstensi = $foto_file->extension();
        $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
        $foto_file->move(public_path('foto'), $foto_nama);

        $data = [
        'nomor_induk' => $request->input('nomor_induk'),
        'nama' => $request->input('nama'),
        'ttl' => $request->input('ttl'),
        'alamat' => $request->input('alamat'),
        'foto' => $foto_nama
        ];
        siswa::create($data);
        return redirect('siswa')->with('success', 'berhasil insert data'); 
    
        //return 'abc';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = siswa::where('nomor_induk', $id)->first();
        return view('siswa/show')-> with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        //$data = DB::table('siswa')->where('nomor_induk', $id)->get();
        //return view('edit', ['data' => $data]);
        
        $data = siswa::where('nomor_induk',$id)->first();
        return view('siswa/edit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'ttl' => 'required',
            'alamat' => 'required'
            ],[
             //'nomor_induk.numeric' => 'Nomor induk harus angka',
             'nama.required' => 'Nama wajib diisi',
             'ttl.required' => 'Ttl wajib diisi',
             'alamat.required' => 'Alamat wajib diisi'
            ]);
            // $data = siswa::find($id);
            // $data->nama = $request->nama;
            // $data->alamat = $request->alamat;
            // $data->save();
            $data = [
            'nama' => $request->input('nama'),
            'ttl' => $request->input('ttl'), 
            'alamat' => $request->input('alamat')
            ];
            
            if($request->hasFile('foto')) {
               $request->validate([
                  'foto' => 'mimes:jpeg,jpg,png,gif'

               ],[
                   'foto.mimes' => 'Foto hanya diperbolehkan berekstensi JPEG, JPG, PNG dan GIF'
               ]);

               $foto_file = $request->file('foto');
               $foto_ekstensi = $foto_file->extension();
               $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
               $foto_file->move(public_path('foto'), $foto_nama); //sudah terupload ke direktori

               $data_foto = siswa::where('nomor_induk', $id)->first();
               File::delete(public_path('foto'). '/' .$data_foto->foto);

               //$data = [
               //'foto' => $foto_nama 
               //];

               $data['foto'] = $foto_nama;

            }

            siswa::where('nomor_induk', $id)->update($data);
            return redirect('/siswa')->with('success','Berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = siswa::where('nomor_induk', $id)->first();
        File::delete(public_path('foto'). '/' . $data->foto);

        siswa::where('nomor_induk', $id)->delete();
        return redirect('/siswa')->with('success', 'berhasil hapus data');
    }

    
}
