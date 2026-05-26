<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterDepartement extends Model
{
    use HasFactory;

    protected $table = 'master_departements';

    protected $fillable = ['name'];

    public function lowongans(): HasMany
    {
        return $this->hasMany(MasterLowongan::class, 'dept_id');
    }
}
