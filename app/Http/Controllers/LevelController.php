<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?,?,?)',['CUS','Pelanggan',now()]);

        // return 'insert data baru berhasil';

        // $row= DB::update('update m_level set level_nama=? where level_kode=?',['Customer','CUS']);
        // return 'update data berhasil. Jumlah data yang diupdate: '.$row.' baris';

        // $row= DB::delete('delete from m_level where level_kode=?',['CUS']);
        // return 'Delete data berhasil. Jumlah data yang didelete: '.$row.' baris';

        // $data = DB::select('Select* FROM m_level');
        // return view('level', compact('data'));
        $breadcrumb = (object)[
            'title' => 'level',
            'list' => ['Home', 'level'],
        ];

        $page = (object)[
            'title' => 'Daftar level Yang Telah Terdaftar Dalam Sistem'
        ];

        $activeMenu = 'level'; //set menu yang sedang aktif

        $level = LevelModel::all();

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }
    public function list(Request $request)
    {
        $level = levelModel::select('level_id','level_kode', 'level_nama');

        if ($request->level_id) {
            $level = $level->where('level_id', $request->level_id);
        }
        return DataTables::of($level)
            //menambah kolom index /no urut (default nama Kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                // $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">
                // detail</a>';
                // $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">
                // edit</a>';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">';
                // $btn .= csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn  = '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/level/' . $level->level_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolomaksi adalah html
            ->make(true);
    }
    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('level.create_ajax', ['level' => $level]);
    }
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_nama' => 'required|string|min:3|unique:m_level,level_nama',
                'level_kode' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data level gagal disimpan',
                    'msgFeild' => $validator->errors(),
                ]);
            }

            levelModel::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Data level berhasil disimpan',
            ]);
        }
        redirect('/');
    }
    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request via AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|max:20|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama'     => 'required|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $level = levelModel::find($id);

            if ($level) {
                // Jika password tidak diisi, hapus dari request
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }

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
        $level = levelModel::find($id);
        if (!$level) {
            return response()->view('level.not_found_ajax');
        }
        return view('level.show_ajax', compact('level'));
    }
    public function detail_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = levelModel::with('level')->find($id);
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
        $level = levelModel::find($id);
        return view('level.confirm_ajax', ['level' => $level]);
    }
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = levelModel::find($id);
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
}
