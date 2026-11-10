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
}
