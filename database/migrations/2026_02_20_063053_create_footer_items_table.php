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
        Schema::create('footer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_section_id')
            ->constrained()
            ->onDelete('cascade');
            $table->string('pemeriksaan');
            $table->decimal('harga_normal', 15, 2);
            $table->decimal('harga_promo', 15, 2);
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('footer_items');
    }
};
