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
        Schema::create("driver", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("nama_lengkap");
            $table->text("alamat");
            $table->string("no_tlp");
            $table->string("email");
            $table->string("password");
            $table->enum('role', ['driver'])->default('driver');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("driver");
    }
};