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
        Schema::create('tb_beban_ops', function (Blueprint $table) {
            $table->id();
            $table->string('periode');
            $table->integer('inventaris')->default(0);
            $table->integer('reimburse')->default(0);
            $table->integer('pulsa')->default(0);
            $table->datetime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_beban_ops');
    }
};
