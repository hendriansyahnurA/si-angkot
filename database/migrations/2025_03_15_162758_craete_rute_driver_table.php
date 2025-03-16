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
        Schema::create("rute", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("driver_id");
            $table->decimal("latitude", 10, 7);
            $table->decimal("longitude", 10, 7);
            $table->timestamps();
            $table->foreign("driver_id")->references("id")->on("driver")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("rute");
    }
};
