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
        Schema::create('tb_sales', function (Blueprint $table) {
            $table->string('sales_code')->primary();
            $table->string('sales_name');
            $table->text('address')->nullable();
            $table->string('phone_number_1');
            $table->string('phone_number_2')->nullable();
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sales');
    }
};
