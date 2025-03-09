<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::table('rental_services', function (Blueprint $table) {
      $table->foreignId('rental_id')->nullable()->change();
      $table->string('service_name')->nullable()->change();
      $table->decimal('service_price', 10, 2)->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down()
  {
    Schema::table('rental_services', function (Blueprint $table) {
      $table->foreignId('rental_id')->nullable(false)->change();
      $table->string('service_name')->nullable(false)->change();
      $table->decimal('service_price', 10, 2)->nullable(false)->change();
    });
  }
};
