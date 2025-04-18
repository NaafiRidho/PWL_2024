<?php

namespace App\Http\Controllers;

use App\DataTables\kategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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

        $breadcrumb = (object)[
            'title' => 'Kategori',
            'list' => ['Home', 'Kategori'],
        ];

        $page = (object)[
            'title' => 'Daftar Kategori Yang Telah Terdaftar Dalam Sistem'
        ];

        $activeMenu = 'kategori'; //set menu yang sedang aktif

        $kategori = KategoriModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategori' => $kategori]);
    }
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->level_id) {
            $kategori = $kategori->where('kategori_id', $request->level_id);
        }
        return DataTables::of($kategori)
            //menambah kolom index /no urut (default nama Kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                // $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">
                // detail</a>';
                // $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">
                // edit</a>';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">';
                // $btn .= csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn  = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolomaksi adalah html
            ->make(true);
    }

    public function create_ajax()
    {
        $level = KategoriModel::select('kategori_id', 'kategori_nama', 'kategori_nama')->get();

        return view('kategori.create_ajax', ['level' => $level]);
    }
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_nama' => 'required|string|min:3|unique:m_kategori,kategori_nama',
                'kategori_kode' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data level gagal disimpan',
                    'msgField' => $validator->errors(),
                ]);
            }

            KategoriModel::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Data level berhasil disimpan',
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $level = KategoriModel::find($id);
        return view('kategori.edit_ajax', ['kategori' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request via AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|max:20|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama'     => 'required|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgFeild' => $validator->errors()
                ]);
            }

            $level = KategoriModel::find($id);

            if ($level) {
                $level->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        // Jika bukan request AJAX, redirect ke homepage
        return redirect('/');
    }

    public function show_ajax($id)
    {
        $level = KategoriModel::find($id);
        if (!$level) {
            return response()->view('level.not_found_ajax');
        }
        return view('kategori.show_ajax', compact('level'));
    }
    public function detail_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = KategoriModel::with('level')->find($id);
            if (!$level) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            } else {
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil ditampilkan'
                ]);
            }
        }
    }

    public function confirm_ajax(string $id)
    {
        $level = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $level]);
    }
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = KategoriModel::find($id);
            if (!$level) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            } else {
                $level->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        }
        return redirect('/');
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

    public function delete($id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        return redirect('/kategori');
    }
}
