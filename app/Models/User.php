<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama', 'email', 'password', 'role'])]
#[Hidden(['password'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Relasi User dengan Projects.
     * Satu klien dapat memiliki banyak proyek.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    /**
     * Relasi User dengan Bids.
     * Satu developer dapat memiliki banyak penawaran.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'developer_id');
    }

    /**
     * Pengaturan tipe data dan hashing password.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
