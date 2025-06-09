<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan dulu tidak ada data yang bertentangan sebelum ubah ke ENUM
        // Ubah kolom size menjadi ENUM
        Schema::table('products', function (Blueprint $table) {
            $table->enum('size', ['XS', 'S', 'M', 'L', 'XL', 'XXL'])->nullable()->change();
        });
    }

    public function down(): void
    {
        // Kembalikan ke varchar(255) jika rollback
        Schema::table('products', function (Blueprint $table) {
            $table->string('size', 255)->nullable()->change();
        });
    }
};

