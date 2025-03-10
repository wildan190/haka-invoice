<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::table('customers', function (Blueprint $table) {
      // Mengubah kolom email dan address menjadi nullable
      $table->string('email')->nullable()->change();
      $table->text('address')->nullable()->change();
    });
  }

  public function down(): void
  {
    Schema::table('customers', function (Blueprint $table) {
      // Mengembalikan kolom email dan address menjadi tidak nullable
      $table->string('email')->nullable(false)->change();
      $table->text('address')->nullable(false)->change();
    });
  }
};
