<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Pastikan ini diimpor jika belum

class Role extends Model
{
    use HasFactory;

    /**
     * Menentukan kolom yang bisa diisi secara massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    /**
     * Aktifkan timestamp created_at dan updated_at
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Relasi ke model User (One-to-Many)
     * Setiap role bisa dimiliki banyak user
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
