<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\form;

class UserController extends Controller
{
    public function index()
    {
        // $data = [
        //     'username' => 'customer-1',
        //     'name' => 'Pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 3
        // ];
        // UserModel::insert($data);

        // $data = [
        //     'name' => 'Pelanggan Pertama'
        // ];
        // UserModel::where('username', 'customer-1')->update($data);

        // $user = UserModel::all();
        // return view('user', compact('user'));

        // $data =[
        //     'level_id'=>2,
        //     'username'=>'manager_tiga',
        //     'name'=>'Manager 3',
        //     'password'=>Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user',['user'=>$user]);

        // $user=UserModel::where('level_id',1)->first();
        // return view('user',['user'=>$user]);

        // $user=UserModel::firstWhere('level_id',1);
        // return view('user',['user'=>$user]);

        // $user=UserModel::findor(20,['username','name'],function(){
        //     abort(404);
        // });
        // return view('user',['user'=>$user]);

        // $user=UserModel::findorfail(1);
        // return view('user',['user'=>$user]);

        // $user=UserModel::where('username','manager9')->firstorfail();
        // return view('user',['user'=>$user]);

        // $user=UserModel::where('level_id',2)->count();
        // return view('user',['user'=>$user]);

        // $user= UserModel::firstorcreate(
        //     [
        //         'username'=>'manager22',
        //         'name'=>'Manager dua dua',
        //         'password'=>Hash::make('12345'),
        //         'level_id'=>2
        //     ],
        // );
        // return view('user',['user'=>$user]);

        // $user= UserModel::firstornew(
        //     [
        //         'username'=>'manager33',
        //         'name'=>'Manager Tiga Tiga',
        //         'password'=>Hash::make('12345'),
        //        'level_id'=>2
        //     ],
        // );
        // $user->save();
        // return view('user',['user'=>$user]);

        // $user= UserModel::create([
        //     'username'=>'manager55',
        //     'name'=>'Manager55',
        //     'password'=>Hash::make('12345'),
        //     'level_id'=>2
        // ]);

        // $user->username='manager56';

        // $user->isDirty();
        // $user->isDirty('username');
        // $user->isDirty('name');
        // $user->isDirty(['name','username']);

        // $user->isClean();
        // $user->isClean('username');
        // $user->isClean('name');
        // $user->isClean(['name','username']);

        // $user->save();

        // $user->isDirty();
        // $user->isClean();

        // $user->wasChanged();
        // $user->wasChanged('username');
        // $user->wasChanged(['username','name']);
        // $user->wasChanged('name');
        // dd( $user->wasChanged(['username','name']));

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        // $user = UserModel::with('level')->get();
        // return view('user',['data'=>$user]);

        $breadcrumb = (object)[
            'title' => 'User',
            'list' => ['Home', 'User'],
        ];

        $page = (object)[
            'title' => 'Daftar User Yang Telah Terdaftar Dalam Sistem'
        ];

        $activeMenu = 'user'; //set menu yang sedang aktif

        $level = LevelModel::all();

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }

    public function list(Request $request)
    {
        $user = UserModel::select('user_id', 'username', 'name', 'level_id')
            ->with('level');

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
                $btn  = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) //memberitahu bahwa kolomaksi adalah html
            ->make(true);
    }
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah'],
        ];

        $page = (object)[
            'title' => 'Tambah User Baru'
        ];

        $level = LevelModel::all(); //mengambil semua level dab akan ditampilkan didalam form
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'name' => 'required|string|max:100',
            'level_id' => 'required|integer',
            'password' => 'required|min:5',
        ]);

        UserModel::create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'level_id' => $request->input('level_id'),
            'password' => bcrypt($request->input('password')),
        ]);
        return redirect('/user')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail'],
        ];

        $page = (object)[
            'title' => 'Detail User',
        ];

        $activeMenu = 'user';
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $user = UserModel::with('level')->find($id);
        $level = LevelModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit'],
        ];

        $page = (object)[
            'title' => 'Edit User',
        ];
        $activeMenu = 'user';
        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'name' => 'required|string|max:100',
            'level_id' => 'required|integer',
            'password' => 'nullable|min:5',
        ]);
        $user = UserModel::find($id)->update([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'level_id' => $request->input('level_id'),
            'password' => bcrypt($request->input('password')),
        ]);
        return redirect('/user')->with('success', 'Data User berhasildiubah');
    }
    public function destroy(string $id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return redirect('/user')->with('error', 'Data User tidak ditemukan');
        }
        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'Data User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'Data User gagal dihapus');
        }
    }
    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|string|min:3|unique:m_user,username',
                'name' => 'required|string|max:100',
                'level_id' => 'required|integer',
                'password' => 'required|min:5',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data User gagal disimpan',
                    'msgFeild' => $validator->errors(),
                ]);
            }

            UserModel::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Data User berhasil disimpan',
            ]);
        }
        redirect('/');
    }
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }
    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request via AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'name'     => 'required|max:100',
                'password' => 'nullable|min:6|max:20',
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

            $user = UserModel::find($id);

            if ($user) {
                // Jika password tidak diisi, hapus dari request
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }

                $user->update($request->all());

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
        $user = UserModel::with('level')->find($id);
        if (!$user) {
            return response()->view('user.not_found_ajax');
        }
        return view('user.show_ajax', compact('user'));
    }
    public function detail_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::with('level')->find($id);
            if (!$user) {
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
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if (!$user) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            } else {
                $user->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
        }
        return redirect('/');
    }


    // public function tambah()
    // {
    //     return view('user_tambah');
    // }
    // public function tambah_simpan(Request $request)
    // {
    //     UserModel::create([
    //         'username' => $request->username,
    //         'name' => $request->name,
    //         'password' => Hash::make('$request->password'),
    //         'level_id' => $request->level_id
    //     ]);
    //     return redirect('/user');
    // }

    // public function ubah($id)
    // {
    //     $user = UserModel::find($id);
    //     return view('user_ubah', ['data' => $user]);
    // }

    // public function ubah_simpan($id, Request $request){
    //     $user= UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->name = $request->name;
    //     $user->password = Hash::make($request->password);
    //     $user->level_id = $request->level_id;

    //     $user->save();

    //     return redirect('/user');
    // }

    // public function hapus($id){
    //     $user= UserModel::find($id);
    //     $user->delete();

    //     return redirect('/user');
    // }
}
