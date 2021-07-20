<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\AuthCode;
use DateTime;

class LoginController extends Controller
{
    public function index() {
        return view('login');
    }

    // 認証コードが送信されてきた時のメソッド
    public function postAuthCode(Request $request) {
        // セッションを開始する
        session_start();
        $auth_code = $request->input('auth-code');
        // 認証コードのチェック
        $result = $this->checkAuthDateUse($auth_code);
        if ($result->get('code') == 1) {
            return redirect('/');
        } else {
            return redirect('/login')->with('error', $result->get('error'));
        }
    }

    /**
     * 認証コードの有効期限チェック
     * @param string $auth_code 認証コード
     * 
     * @return collection
     * code=>0:error, 1:succes
     * error=>エラーメッセージ 
     */
    public static function checkAuthDateUse($auth_code) {
        // 認証コードのチェック
        $result = AuthCode::checkAuthCode($auth_code);
        // collection作成
        $collection = new Collection();
        // 有効時間内か確認
        if ($result != 'null') {
            if ($result == 'unused') { // 未使用の場合
                $result2 = AuthCode::saveDateUse($auth_code);
                if(!$result2) {
                    return $collection = collect([
                        'code' => 0,
                        'error' => config('error_message.DB_ERROE'),
                    ]);
                } else {
                    // セッションにコードを一時保存
                    session(['auth_code' => $auth_code]);
                    return $collection = collect([
                        'code' => 1,
                        'error' => '',
                    ]);
                }
            } elseif($result == 'admin') { // 無期限コードの場合
                // セッションにコードを一時保存
                session(['auth_code' => $auth_code]);
                return $collection = collect([
                    'code' => 1,
                    'error' => '',
                ]);
            } else {
                // 使用日付に1時間加算
                $tmp_date = new DateTime($result);
                $tmp_date = $tmp_date->modify('+1 hours');
                // 現在時刻取得し期限内か確認
                $now = new DateTime(now()->format('Y-m-d H:i:s'));
                if ($now < $tmp_date) { // 期限内
                    // セッションにコードを一時保存
                    session(['auth_code' => $auth_code]);
                    return $collection = collect([
                        'code' => 1,
                        'error' => '',
                    ]);
                } else { // 期限外
                    return $collection = collect([
                        'code' => 0,
                        'error' => config('error_message.CODE_OVERDUE'),
                    ]);
                    // return redirect('/login')->with('error', config('error_message.CODE_OVERDUE'));
                }
            }
        } else { // nullの場合
            return $collection = collect([
                'code' => 0,
                'error' => config('error_message.CODE_ERROR'),
            ]);
        }
    }
}
