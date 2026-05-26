<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterLowongan extends Model
{
    use HasFactory;

    protected $table = 'master_lowongans';

    protected $fillable = [
        'dept_id',
        'posisi',
        'quota',
        'deskripsi',
        'user_created',
        'user_updated',
    ];

    public function departement(): BelongsTo
    {
        return $this->belongsTo(MasterDepartement::class, 'dept_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_created');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_updated');
    }

    public function pendaftars(): HasMany
    {
        return $this->hasMany(TransaksiPendaftar::class, 'id_lowongan');
    }
}
