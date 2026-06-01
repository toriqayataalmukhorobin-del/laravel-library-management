<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Borrowing;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'qr_code'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->qr_code)) {
                $user->qr_code = 'QR-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
            }
        });
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function generateQrCode()
    {
        $this->qr_code = 'QR-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
        $this->save();
        return $this->qr_code;
    }

    public function getQrDataAttribute()
    {
        return json_encode([
            'id' => $this->id,
            'code' => $this->qr_code,
            'name' => $this->name,
            'username' => $this->username,
            'role' => $this->role
        ]);
    }
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
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
}
