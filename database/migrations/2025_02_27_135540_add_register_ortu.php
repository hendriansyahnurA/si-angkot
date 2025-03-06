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
        Schema::create("orang_tua", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("nama_lengkap");
            $table->text("alamat");
            $table->string("no_tlp");
            $table->string("email");
            $table->string("password");
            $table->enum('role', ['orang tua'])->default('orang tua');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orang_tua");
    }
};