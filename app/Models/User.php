<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens;

    // Tentukan kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'phone',
        'password',
    ];

    // Tentukan kolom yang tidak boleh diubah
    protected $guarded = [];

    // Menggunakan UUID sebagai primary key
    protected $primaryKey = 'id';

    // Jangan gunakan auto-incrementing untuk UUID
    public $incrementing = false;

    // Tentukan tipe kolom UUID
    protected $keyType = 'string';

    // Hash password secara otomatis
    protected static function boot()
    {
        parent::boot();

        // Pastikan UUID dihasilkan saat membuat pengguna baru
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString(); // Menghasilkan UUID baru
            }
        });
    }

    // Fungsi untuk mendapatkan atribut password yang di-hash
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
