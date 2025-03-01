<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('mobil_id')->constrained()->onDelete('cascade');
            $table->enum('rental_type', ['hari', 'bulan']);
            $table->integer('duration');
            $table->decimal('total_price', 15, 2);
            $table->boolean('use_dp')->default(false);
            $table->decimal('dp_paid', 15, 2)->nullable();
            $table->decimal('remaining_payment', 15, 2)->nullable();
            $table->decimal('ppn', 15, 2);
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
