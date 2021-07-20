<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Favorite extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'auth_code',
        'favorite_num',
    ];

    /**
     * お気に入り数追加
     * @param string $authCode 認証コード
     * 
     * @return boolean
     */
    public static function scopeAddFavorite($query, $authCode) {
        // トランザクション
        DB::beginTransaction();
        try {
            $result = $query->where('auth_code', '=', $authCode)->first();
            $result->favorite_num = $result->favorite_num + 1;
            $result->update();
            // commitしないと保存されない
            DB::commit();
        } catch(\Exception $e) {
            DB::rollback();
            return false;
        }
        return true;
    }

    /**
     * お気に入り数取得
     * @param string $authCode 認証コード
     * 
     * @return string
     */
    public static function scopeGetFavorite($query, $authCode) {
        // トランザクション
        return $query->where('auth_code', '=', $authCode)->first();
    }
}
