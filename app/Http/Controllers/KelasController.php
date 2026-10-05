<?php


namespace App\Http\Controllers;
use App\kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KelasController extends Controller
{
    public function index(Request $request)
    {

    $query = Kelas::query();

    // Filter berdasarkan kelas
    if ($request->filled('kelas')) {
        $query->where('kelas', $request->kelas);
    }

    // Filter berdasarkan tahun ajaran
    if ($request->filled('tahun_ajaran')) {
        $query->where('tahun_ajaran', $request->tahun_ajaran);
    }

    $data = $query->orderBy('nama', 'asc')
                  ->paginate(10)
                  ->withQueryString();

    // Ambil data unik untuk combobox
    $kelasList = Kelas::select('kelas')
                      ->distinct()
                      ->orderBy('kelas')
                      ->pluck('kelas');

    $tahunList = Kelas::select('tahun_ajaran')
                      ->distinct()
                      ->orderBy('tahun_ajaran')
                      ->pluck('tahun_ajaran');



    // $field = $request->field;
    // $search = $request->search;

    // $query = Kelas::query();

    // if ($search && in_array($field, ['kelas','tahun_ajaran'])){
    // $query->where($field, 'like', "%{search}%");
    // }

    // $data = $query->orderBy('nama', 'asc')
    //               ->paginate(10)
    //               ->withQueryString();
                  
    // $search = $request->search;
       
    //        $data = kelas::when($search, function ($query, $search) {
    //                    return $query->where('kelas', 'like', "%{$search}%")
    //                                 ->orWhere('tahun_ajaran', 'like', "%{$search}%");
    //                })
    //                ->orderBy('nama', 'desc')
    //                ->paginate(10)
    //                ->withQueryString(); // agar paginasi tetap bawa query 'search'
       
           
    if ($data->count() ==0) {
    return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

           return view('kelas.index', compact('data','kelasList','tahunList'));
    }

    public function create()
    {
        return view('kelas/create');
    }


    public function store(Request $request)
    {

    $request->validate([
        'nomor_induk' => 'required|numeric',
        'nama' => 'required',
        'kelas' => 'required',
        'tahun_ajaran' => 'required'
        ],[
         'nomor_induk.required' => 'Nomor induk wajib diisi',
         'nomor_induk.numeric' => 'Nomor induk harus angka',
         'nama.required' => 'Nama wajib diisi',
         'kelas.required' => 'Kelas wajib diisi',
         'tahun_ajaran.required' => 'Tahun ajaran wajib diisi'
        ]);

        $data = [
        'nomor_induk' => $request->input('nomor_induk'),
        'nama' => $request->input('nama'),
        'kelas' => $request->input('kelas'),
        'tahun_ajaran' => $request->input('tahun_ajaran')
        ];
        kelas::create($data);
        return redirect('kelas')->with('success', 'berhasil insert data');

    }

public function show($id)
{
   
$data = kelas::where('id', $id)->first();
return view('kelas/show')->with('data', $data);

}

public function edit($id)
{

$data = kelas::where('id', $id)->first();
return view('kelas/edit')->with('data', $data);

}


public function update(Request $request, $id)
{

$request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'tahun_ajaran' => 'required'
            ],[
             'nama.required' => 'Nama wajib diisi',
             'kelas.required' => 'Kelas wajib diisi',
             'tahun_ajaran.required' => 'Tahun Ajaran wajib diisi'
            ]);
            
            $data = [
            'nama' => $request->input('nama'),
            'kelas' => $request->input('kelas'), 
            'tahun_ajaran' => $request->input('tahun_ajaran')
            ];
            
            kelas::where('id', $id)->update($data);
            return redirect('/kelas')->with('success','Berhasil melakukan update data');


}

public function destroy($id)
{

$data = kelas::where('id', $id)->first();
kelas::where('id', $id)->delete();
return redirect('/kelas')->with('success', 'data kelas telah dihapus');

}







}
