<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel database secara eksplisit.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * Primary key tabel secara eksplisit.
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
        'name',
        'phone_number',
        'address',
        'internet_package',
        'package_price',
        'status',
    ];

    /**
     * Tipe data casting atribut secara eksplisit.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'package_price' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke entitas tagihan (Invoice) secara eksplisit.
     *
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'customer_id', 'id');
    }

    /**
     * Scope query untuk pencarian data pelanggan berdasarkan kata kunci.
     *
     * @param Builder $query
     * @param string|null $keyword
     * @return Builder
     */
    public function scopeSearchByKeyword(Builder $query, ?string $keyword): Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $subQuery) use ($keyword) {
            $subQuery->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('phone_number', 'LIKE', "%{$keyword}%")
                ->orWhere('address', 'LIKE', "%{$keyword}%")
                ->orWhere('internet_package', 'LIKE', "%{$keyword}%");
        });
    }

    /**
     * Scope query untuk pengurutan data pelanggan secara dinamis dan aman.
     *
     * @param Builder $query
     * @param string|null $column
     * @param string|null $direction
     * @return Builder
     */
    public function scopeSortCustomerRecords(Builder $query, ?string $column, ?string $direction): Builder
    {
        $allowedColumns = ['name', 'phone_number', 'internet_package', 'package_price', 'status', 'created_at'];
        $sortColumn = in_array($column, $allowedColumns, true) ? $column : 'created_at';
        $sortDirection = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortColumn, $sortDirection);
    }
}
