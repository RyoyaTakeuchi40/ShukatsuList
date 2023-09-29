<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index() {
        return view('tests.test'); // viewはLaravelのヘルパ関数 フォルダ名.ファイル名 }
    }
}
