<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriLaporanHarian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'kat_lap_harian'; // Nama tabel
    protected $primaryKey = 'id_kat';         // Primary key
    public $incrementing  = false;            // Tidak auto-increment

    protected $fillable = [
        'id_kat',
        'nm_kategori',
    ];

    /**
     * Relasi one-to-many ke LaporanHarian.
     */
    public function laporanHarian(): HasMany
    {
        return $this->hasMany(LaporanHarian::class, 'id_kat', 'id_kat');
    }
}
