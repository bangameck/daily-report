<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KeteranganLaporanHarian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'ket_lap_harian'; // Nama tabel
    protected $primaryKey = 'id_ket_lap';     // Primary key

    protected $fillable = [
        'lap_harian_id',
        'pengawas_id',
        'ket_reject',
    ];

    /**
     * Relasi one-to-one (inverse) ke LaporanHarian.
     */
    public function laporanHarian(): BelongsTo
    {
        return $this->belongsTo(LaporanHarian::class, 'lap_harian_id', 'id_lap');
    }

    /**
     * Relasi many-to-one ke User (Pengawas).
     */
    public function pengawas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengawas_id', 'id');
    }
}
