<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'project_id',
    'developer_id',
    'harga',
    'durasi',
    'proposal',
    'is_winner'
])]
class Bid extends Model
{
    use HasFactory;

    /**
     * Relasi Bid dengan Project.
     * Setiap penawaran dimiliki oleh satu proyek.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Relasi Bid dengan User.
     * Setiap penawaran dibuat oleh satu developer.
     */
    public function developer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Pengaturan tipe data.
     */
    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'durasi' => 'integer',
            'is_winner' => 'boolean',
        ];
    }
}
