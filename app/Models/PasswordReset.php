<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PasswordReset extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'token'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($reset) {
            $reset->token = Str::random(64);
        });
    }

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }
}
