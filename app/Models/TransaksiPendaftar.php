<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPendaftar extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pendaftars';

    protected $fillable = [
        'user_id',
        'id_lowongan',
        'name',
        'gender',
        'dob',
        'adres',
        'no_telp',
        'university',
        'major',
        'ipk',
        'status',
        'path_cv',
    ];

    protected $casts = [
        'dob' => 'date',
        'ipk' => 'float',
    ];

    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(MasterLowongan::class, 'id_lowongan');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
