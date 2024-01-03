<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Test; // Testモデルを使えるように読み込む

class TestController extends Controller
{
    public function index()
    {
        $values = Test::all(); // 全件取得
        $count = Test::count(); // 数字
        $first = Test::findOrFail(1); // インスタンス
        $whereBBB = Test::where('text', '=', 'bbb'); // Eloquent/Builder 
        $whereBBB = Test::where('text', '=', 'bbb')->get(); // Collection 
        DB::table('tests')->where('text', '=', 'bbb')->select('id', 'text')->get(); // コレクション型
        // dd($values, $count, $first, $whereBBB); // die + var_dump 処理を止めて内容を確認できる
        //compact関数でView側に変数を渡すと楽
        // 変数が複数あってもコンマでつなげば複数渡せる
        return view('tests.test', compact('values'));
    }
}
