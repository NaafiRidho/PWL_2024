<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\KategoriModel;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Barang',
            'list' => ['Home', 'Barang'],
        ];

        $page = (object)[
            'title' => 'Daftar User Yang Telah Terdaftar Dalam Sistem'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif

        $level = BarangModel::all();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'barang' => $level]);
    }

    public function list(Request $request)
    {
        $user = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->with('kategori');

        if ($request->level_id) {
            $user = $user->where('level_id', $request->level_id);
        }
        return DataTables::of($user)
            //menambah kolom index /no urut (default nama Kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                // $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">
                // detail</a>';
                // $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">
                // edit</a>';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">';
                // $btn .= csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $user->barang_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $user->barang_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $user->barang_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolomaksi adalah html
            ->make(true);
    }


    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.create_ajax')
            ->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'  => 'required',
                'barang_kode'  => 'required|string|min:3|max:20|unique:m_barang,barang_kode',
                'barang_nama'  => 'required|string|max:100',
                'harga_beli'   => 'required|numeric|min:0',
                'harga_jual'   => 'required|numeric|min:0|gte:harga_beli',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal. Data barang tidak disimpan.',
                    'msgField' => $validator->errors(),
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Data barang berhasil disimpan',
            ]);
        }

        return redirect('/');
    }
    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);

        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.edit_ajax', [
            'barang'   => $barang,
            'kategori' => $kategori
        ]);
    }
    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request via AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'  => 'required|integer',
                'barang_kode'  => 'required|string|min:3|max:20|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama'  => 'required|string|max:100',
                'harga_beli'   => 'required|numeric|min:0',
                'harga_jual'   => 'required|numeric|min:0|gte:harga_beli',
            ];

            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal. Data barang tidak diupdate.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Cari barang berdasarkan ID
            $barang = BarangModel::find($id);

            if ($barang) {
                // Update data barang
                $barang->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data barang tidak ditemukan'
                ]);
            }
        }

        // Jika bukan request AJAX, redirect ke homepage
        return redirect('/');
    }
    public function show_ajax($id)
    {
        // Cari barang beserta relasi kategori
        $barang = BarangModel::with('kategori')->find($id);

        // Jika tidak ditemukan, munculkan view not_found
        if (! $barang) {
            return response()->view('barang.not_found_ajax');
        }

        // Tampilkan view detail_ajax dengan data $barang
        return view('barang.show_ajax', compact('barang'));
    }
    public function detail_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::with('kategori')->find($id);

            if (! $barang) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data barang tidak ditemukan'
                ]);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Data barang berhasil ditampilkan'
            ]);
        }

        // Bukan request AJAX? Redirect ke index
        return redirect('/barang');
    }

    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);

            if (!$barang) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data barang tidak ditemukan'
                ]);
            } else {
                // Hapus data barang
                $barang->delete();

                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil dihapus'
                ]);
            }
        }

        // Jika bukan request AJAX, redirect ke halaman daftar barang
        return redirect('/barang');
    }
}
