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
        Schema::create('tb_vbelt', function (Blueprint $table) {
            $table->id();
            $table->string('type_code');
            $table->string('model');
            $table->integer('size_min')->default(0);
            $table->integer('size_max')->default(0);
            $table->string('price')->default(0);
            $table->enum('price_unit', ['PCS', 'INCH']);
            $table->float('discount')->default(0);
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_vbelt');
    }
};
