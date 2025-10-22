<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokumentasiLaporanHarian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'd_lap_harian'; // Nama tabel
    protected $primaryKey = 'id_d_lap';     // Primary key

    protected $fillable = [
        'lap_harian_id',
        'n_d_lap',
        'x_lap',
    ];

    /**
     * Relasi many-to-one ke LaporanHarian.
     */
    public function laporanHarian(): BelongsTo
    {
        return $this->belongsTo(LaporanHarian::class, 'lap_harian_id', 'id_lap');
    }
}
