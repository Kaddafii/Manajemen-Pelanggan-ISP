<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi pembuatan tabel pelanggan (customers).
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone_number', 20);
            $table->text('address');
            $table->string('internet_package', 100);
            $table->decimal('package_price', 12, 2)->unsigned();
            $table->enum('status', ['Aktif', 'Suspend', 'Putus'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Membatalkan migrasi tabel pelanggan.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
