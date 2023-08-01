<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticaleController extends Controller
{

    public function __construct()
{
    $this->middleware('permission:index articles|edit articles',['only' =>['index']]);
    $this->middleware('permission:create articles',['only' =>['create']]);
    $this->middleware('permission:edit articles',['only' =>['edit']]);
}
    public function index(){
        return 'index';
    }
    public function create(){
        return view('index');
    }
    public function edit(){
        return 'edit';
    }
}
