<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom address jika belum ada
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address')->nullable()->after('order_number');
            }
            
            // Menambahkan kolom total_price jika belum ada
            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->integer('total_price')->default(0)->after('address');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['address', 'total_price']);
        });
    }
};