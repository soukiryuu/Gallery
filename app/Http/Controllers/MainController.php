<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function index()
    {
        // 認証のチェック
        if (session()->has('auth_code')) { // セッションに存在している場合
            $result = $this->checkAuthCode();
            if ($result->get('code') == 0) {
                return redirect('/login')->with('error', $result->get('error'));
            }
        } else {
            return redirect('/login');
        }
        // 画像パスの取得
        $path = storage_path('app/public/images/lina');
        $files = \File::files($path);
        // コレクションの作成
        $tmp_paths1 = new Collection();

        foreach ($files as $img) {
            // 文字切り出し
            $tmp_str = explode("/", $img->getPathname());
            // ファイル名だけ抜き出す
            $tmp_filename = explode(".", $tmp_str[10]);
            // ファイル番号
            $tmp_num = explode("_", $tmp_filename[0]);
            $tmp_paths2 = $tmp_paths1->push([
                'num' => $tmp_num[1],
                'path' => $tmp_str[10],
                'text' => $tmp_filename[0]
            ]);
        }
        // 昇順にする
        $paths = $tmp_paths1->sortBy('num')->values()->toArray();

        return view('main', compact('paths'));
    }

    /**
     * 認証コードの有効性チェック
     * 
     * @return collection
     */
    public function checkAuthCode() {
        // セッション取得
        $auth_code = session('auth_code');
        // LoginControllerを呼ぶ
        $login_controller = app()->make('App\Http\Controllers\LoginController');
        return $result = $login_controller->checkAuthDateUse($auth_code);
    }
}
