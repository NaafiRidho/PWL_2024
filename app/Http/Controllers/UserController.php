<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

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

        $user = UserModel::with('level')->get();
        return view('user',['data'=>$user]);
    }

    public function tambah()
    {
        return view('user_tambah');
    }
    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request){
        $user= UserModel::find($id);

        $user->username = $request->username;
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id){
        $user= UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}
