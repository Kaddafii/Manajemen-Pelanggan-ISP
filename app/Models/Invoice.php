<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    /**
     * Nama tabel database secara eksplisit sesuai aturan C.4.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * Primary key tabel secara eksplisit sesuai aturan C.4.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'billing_period',
        'billing_amount',
        'payment_status',
        'payment_date',
    ];

    /**
     * Tipe data casting atribut secara eksplisit sesuai aturan C.4.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'customer_id' => 'integer',
            'billing_amount' => 'decimal:2',
            'payment_date' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke entitas pelanggan (Customer) secara eksplisit dengan foreign key dan local key.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Memeriksa apakah tagihan berstatus Lunas.
     *
     * @return bool
     */
    public function isPaidStatus(): bool
    {
        return $this->payment_status === 'Lunas';
    }

    /**
     * Memeriksa apakah tagihan berstatus Belum Bayar.
     *
     * @return bool
     */
    public function isUnpaidStatus(): bool
    {
        return $this->payment_status === 'Belum Bayar';
    }

    /**
     * Melakukan pelunasan tagihan dengan mencatat waktu pembayaran saat ini.
     *
     * @return bool
     */
    public function markInvoiceAsPaidWithCurrentTimestamp(): bool
    {
        return $this->update([
            'payment_status' => 'Lunas',
            'payment_date' => now(),
        ]);
    }

    /**
     * Scope query untuk pencarian tagihan berdasarkan nama pelanggan atau periode tagihan.
     *
     * @param Builder $query
     * @param string|null $keyword
     * @return Builder
     */
    public function scopeSearchInvoicesByKeyword(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $subQuery) use ($keyword) {
            $subQuery->where('billing_period', 'LIKE', "%{$keyword}%")
                ->orWhereHas('customer', function (Builder $customerQuery) use ($keyword) {
                    $customerQuery->where('name', 'LIKE', "%{$keyword}%")
                        ->orWhere('phone_number', 'LIKE', "%{$keyword}%");
                });
        });
    }

    /**
     * Scope query untuk filter tagihan berdasarkan status pembayaran.
     *
     * @param Builder $query
     * @param string|null $status
     * @return Builder
     */
    public function scopeFilterByPaymentStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status) || !in_array($status, ['Belum Bayar', 'Lunas'], true)) {
            return $query;
        }

        return $query->where('payment_status', $status);
    }

    /**
     * Scope query untuk pengurutan data tagihan secara dinamis dan aman.
     *
     * @param Builder $query
     * @param string|null $column
     * @param string|null $direction
     * @return Builder
     */
    public function scopeSortInvoiceRecords(Builder $query, ?string $column, ?string $direction): Builder
    {
        $allowedColumns = ['billing_period', 'billing_amount', 'payment_status', 'payment_date', 'created_at'];
        $sortColumn = in_array($column, $allowedColumns, true) ? $column : 'created_at';
        $sortDirection = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortColumn, $sortDirection);
    }
}
