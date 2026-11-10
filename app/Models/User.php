<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Nama tabel database secara eksplisit.
     *
     * @var string
     */
    protected $table = 'users';

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
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang disembunyikan dalam serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data casting atribut secara eksplisit.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Memeriksa apakah pengguna memiliki hak akses Administrator.
     *
     * @return bool
     */
    public function isAdministratorRole(): bool
    {
        return $this->role === 'Administrator';
    }

    /**
     * Memeriksa apakah pengguna memiliki hak akses Staff.
     *
     * @return bool
     */
    public function isStaffRole(): bool
    {
        return $this->role === 'Staff';
    }

    /**
     * Scope query untuk pencarian data pengguna berdasarkan kata kunci nama atau email.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $keyword
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchUsersByKeyword(\Illuminate\Database\Eloquent\Builder $query, ?string $keyword): \Illuminate\Database\Eloquent\Builder
    {
        if (empty($keyword)) {
            return $query;
        }

        return $query->where(function (\Illuminate\Database\Eloquent\Builder $subQuery) use ($keyword) {
            $subQuery->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%");
        });
    }

    /**
     * Scope query untuk filter pengguna berdasarkan role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByRole(\Illuminate\Database\Eloquent\Builder $query, ?string $role): \Illuminate\Database\Eloquent\Builder
    {
        if (empty($role) || !in_array($role, ['Administrator', 'Staff'], true)) {
            return $query;
        }

        return $query->where('role', $role);
    }

    /**
     * Scope query untuk pengurutan data pengguna secara dinamis dan aman.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $column
     * @param string|null $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortUserRecords(\Illuminate\Database\Eloquent\Builder $query, ?string $column, ?string $direction): \Illuminate\Database\Eloquent\Builder
    {
        $allowedColumns = ['name', 'email', 'role', 'created_at'];
        $sortColumn = in_array($column, $allowedColumns, true) ? $column : 'created_at';
        $sortDirection = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sortColumn, $sortDirection);
    }
}
