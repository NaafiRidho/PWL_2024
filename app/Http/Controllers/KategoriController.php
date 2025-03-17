<?php

namespace App\Http\Controllers;

use App\DataTables\kategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(kategoriDataTable $dataTable)
    {
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now()
        // ];

        // DB::table('m_kategori')->insert($data);
        // return 'insert data baru berhasil';

        // $row=DB::table('m_kategori')->where('kategori_kode','SNK')->update(['kategori_nama'=>'cemilan']);
        // return 'update data berhasil jumlah data yang diupdate: '.$row.' baris';

        // $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
        // return 'delete data berhasil jumlah data yang didelete: ' . $row . ' baris';

        // $data = DB::table('m_kategori')->get();
        // return view('kategori', compact('data'));

        return $dataTable->render('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'kategori_kode' => 'required|string|max:50',
        'kategori_nama' => 'required|string|max:100',
    ]);

    KategoriModel::create([
        'kategori_kode' => $request->kategori_kode,
        'kategori_nama' => $request->kategori_nama
    ]);

    return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan!');
}

    public function edit($id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.kategori_ubah', ['kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::find($id);

        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->save();

        return redirect('/kategori');
    }

    public function delete($id){
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        return redirect('/kategori');
    }
}
