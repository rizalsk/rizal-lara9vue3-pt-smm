<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_permintaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permintaan_id');
            $table->foreignId('barang_id');
            $table->integer('kuantiti')->default(0);
            $table->mediumText('keterangan')->nullable();
            $table->enum('status', ['terpenuhi', 'tidak terpenuhi'])->default('tidak terpenuhi');
            $table->index(['permintaan_id', 'barang_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_permintaans');
    }
};
