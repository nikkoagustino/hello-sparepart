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
        Schema::table('tb_komisi_sales', function (Blueprint $table) {
            $table->decimal('persen_komisi', 20, 18)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_komisi_sales', function (Blueprint $table) {
            $table->float('persen_komisi')->default(0)->change();
        });
    }
};
