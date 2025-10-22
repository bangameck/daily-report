<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'regu';    // Nama tabel
    protected $primaryKey = 'id_regu'; // Primary key

    protected $fillable = [
        'nm_regu',
        'karu',
        'f_regu',
    ];

    /**
     * Relasi many-to-one ke User (Kepala Regu).
     */
    public function kepalaRegu(): BelongsTo
    {
        return $this->belongsTo(User::class, 'karu', 'id');
    }

    /**
     * Relasi one-to-many ke User (Anggota Regu).
     */
    public function anggota(): HasMany
    {
        return $this->hasMany(User::class, 'regu_id', 'id_regu');
    }

    /**
     * Relasi one-to-many ke LaporanHarian.
     */
    public function laporanHarian(): HasMany
    {
        return $this->hasMany(LaporanHarian::class, 'regu_id', 'id_regu');
    }
}
