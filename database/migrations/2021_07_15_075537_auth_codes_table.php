<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuthCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_codes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('auth_code', 255)->unique()->comment('認証コード');
            $table->integer('dead_line_flg')->default(0)->comment('期限フラグ(0:有限,1:無期限)');
            $table->dateTime('date_use')->nullable()->default(null)->comment('使用開始日');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('作成日');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日');
            $table->softDeletes()->comment('削除日');
        });
        DB::statement("ALTER TABLE auth_codes COMMENT '認証コードテーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_codes');
    }
}
