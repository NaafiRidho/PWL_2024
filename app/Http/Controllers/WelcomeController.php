<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function hello(){
        return 'Hello World';
    }

    public function index(){
        $breadcrumb =(object)[
            'title'=>'Selamat Datang',
            'list' =>['Home','Welcome']
        ];
        $activemenu='dashboard';

        return(view('welcome',['breadcrumb'=>$breadcrumb, 'activeMenu'=>$activemenu]));
    }

    public function about(){
        return ('Naafi Ridho A/22');
    }

    public function articles($id){
        return 'Artikel ke- '.$id;
    }

    public function greeting(){
        return view('blog.hello')
        ->with('name','Naafi')
        ->with('occupation','Astronaut');
    }
}
