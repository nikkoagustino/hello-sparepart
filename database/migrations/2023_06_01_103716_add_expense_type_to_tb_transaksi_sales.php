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
        Schema::table('tb_transaksi_sales', function (Blueprint $table) {
            $table->enum('expense_type', ['beban_ops', 'gaji'])->after('description')->default('beban_ops');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_transaksi_sales', function (Blueprint $table) {
            $table->dropColumn('master_pin');
        });
    }
};
