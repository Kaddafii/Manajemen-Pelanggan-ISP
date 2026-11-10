<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi tabel data tagihan pelanggan ISP.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('billing_period', 50);
            $table->decimal('billing_amount', 12, 2)->unsigned();
            $table->enum('payment_status', ['Belum Bayar', 'Lunas'])->default('Belum Bayar')->index();
            $table->dateTime('payment_date')->nullable()->default(null);
            $table->timestamps();

            // Constraint Foreign Key Eksplisit Sesuai Aturan C.4
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Batalkan migrasi tabel data tagihan pelanggan ISP.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
