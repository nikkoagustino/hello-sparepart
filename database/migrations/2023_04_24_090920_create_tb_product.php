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
        Schema::create('tb_product', function (Blueprint $table) {
            $table->string('product_code')->primary();
            $table->string('product_name');
            $table->integer('price_capital')->default(0);
            $table->integer('price_selling')->default(0);
            $table->string('type_code');
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_product');
    }
};
