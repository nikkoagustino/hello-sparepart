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
        Schema::create('tb_komisi_sales', function (Blueprint $table) {
            $table->id();
            $table->string('sales_code');
            $table->integer('year');
            $table->integer('month');
            $table->float('persen_komisi')->default(0);
            $table->datetime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_komisi_sales');
    }
};
