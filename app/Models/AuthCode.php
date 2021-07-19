<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class AuthCode extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'auth_code',
        'date_use',
    ];

    /**
     * 認証コードがあっているかの確認
     * @param string $authCode 認証コード
     * 
     * @return string $date_use
     */
    public static function scopeCheckAuthCode($query, $authCode) {
        $tmp_result = $query->where('auth_code', '=', $authCode)->first();
        $date_use = "null";
        if(!empty($tmp_result)) { // データがヒットした場合
            $date_use = $tmp_result->date_use;
            if (empty($date_use)) { // 使用日付がNULL(未使用)
                return $date_use = 'unused';
            } else {
                return $date_use;
            }
        } else {
            return $date_use;
        }
    }

    /**
     * 使用日付に現在日付を追加
     * @param string $authCode 認証コード
     * 
     * @return boolean
     */
    public static function scopeSaveDateUse($query, $authCode) {
        // トランザクション
        DB::beginTransaction();
        try {
            $result = $query->where('auth_code', '=', $authCode)->first();
            $result->date_use = now()->format('Y-m-d H:i:s');
            $result->update();
            // commitしないと保存されない
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }
}
