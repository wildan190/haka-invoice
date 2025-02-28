<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Jenis mobil
            $table->string('merk'); // Merek mobil
            $table->decimal('price', 15, 2); // Harga mobil
            $table->text('description')->nullable(); // Deskripsi opsional
            $table->enum('status', ['tersedia', 'disewa', 'perawatan'])->default('tersedia'); // Status mobil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
