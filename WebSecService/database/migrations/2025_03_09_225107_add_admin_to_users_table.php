<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('admin')->default(0); // 0 = مستخدم عادي، 1 = أدمن
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('admin');
    });
}

};
