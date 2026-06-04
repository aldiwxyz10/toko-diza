<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('metode_pembayaran')->default('tunai')->after('total_harga');
            $table->integer('bayar')->nullable()->after('metode_pembayaran');
            $table->integer('kembalian')->nullable()->after('bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'bayar', 'kembalian']);
        });
    }
};
