<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('siniestro_user', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('siniestro_id');
      $table->unsignedBigInteger('user_id');
      $table->timestamps();

      $table->foreign('siniestro_id')->references('id')->on('siniestros')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('siniestro_user');
  }
};
