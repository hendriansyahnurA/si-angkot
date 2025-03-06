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
        Schema::create("anak", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("nama_lengkap");
            $table->string("nisn");
            $table->string("sekolah");
            $table->text("alamat_sekolah");
            $table->string("no_tlp");
            $table->string("email");
            $table->string("password");
            $table->enum('role', ['anak'])->default('anak');


            $table->unsignedBigInteger("user_id");
            $table->enum('status', ['setuju', 'tidak setuju'])->default('tidak setuju');
            $table->foreign('user_id')->on('orang_tua')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("anak");
    }
};