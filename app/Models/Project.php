<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'client_id',
    'judul',
    'deskripsi',
    'kategori',
    'budget_min',
    'budget_max',
    'batas_lelang',
    'status'
])]
class Project extends Model
{
    use HasFactory;

    /**
     * Relasi Project dengan User.
     * Setiap proyek dimiliki oleh satu klien.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Relasi Project dengan Bid.
     * Satu proyek dapat memiliki banyak penawaran.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'project_id');
    }

    /**
     * Pengaturan tipe data.
     */
    protected function casts(): array
    {
        return [
            'budget_min' => 'integer',
            'budget_max' => 'integer',
            'batas_lelang' => 'date',
        ];
    }
}
