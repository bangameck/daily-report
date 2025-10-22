<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanHarian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'lap_harian'; // Nama tabel
    protected $primaryKey = 'id_lap';     // Primary key

    protected $fillable = [
        'no_lap',
        'tgl_lap',
        'jam_s',
        'jam_f',
        'user_id',
        'regu_id',
        'id_kat',
        'laporan',
        'ket_lap',
        'st_lap',
    ];

    protected $casts = [
        'tgl_lap' => 'date',
    ];

    /**
     * Relasi many-to-one ke User (pembuat laporan).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi many-to-one ke Regu.
     */
    public function regu(): BelongsTo
    {
        return $this->belongsTo(Regu::class, 'regu_id', 'id_regu');
    }

    /**
     * Relasi many-to-one ke KategoriLaporanHarian.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriLaporanHarian::class, 'id_kat', 'id_kat');
    }

    /**
     * Relasi one-to-many ke DokumentasiLaporanHarian.
     */
    public function dokumentasi(): HasMany
    {
        return $this->hasMany(DokumentasiLaporanHarian::class, 'lap_harian_id', 'id_lap');
    }

    /**
     * Relasi one-to-one ke KeteranganLaporanHarian (verifikasi).
     */
    public function verifikasi(): HasOne
    {
        return $this->hasOne(KeteranganLaporanHarian::class, 'lap_harian_id', 'id_lap');
    }
}
