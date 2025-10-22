<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nama tabel yang terhubung dengan model.
     *
     * @var string
     */
    protected $table = 'users'; // Nama tabel kita

    /**
     * Primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id'; // Primary key kita

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'username',
        'no_hp',
        'nik',
        'nip',
        'pendidikan',
        'alamat',
        't_lahir',
        'tgl_lahir',
        'jk',
        'role_id', // Foreign key ke roles
        'regu_id', // Foreign key ke regu
        'gol_drh',
        'f_ust',
        'otp',
        'batas_waktu',
        'status',
        'member',
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'tgl_lahir'         => 'date',
        'status'            => 'boolean',
        'member'            => 'boolean',
        'batas_waktu'       => 'datetime',
    ];

    // --- RELASI ELOQUENT ---

    /**
     * Relasi one-to-one ke UserProfile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    /**
     * Relasi many-to-one ke Role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    /**
     * Relasi many-to-one ke Regu.
     */
    public function regu(): BelongsTo
    {
        return $this->belongsTo(Regu::class, 'regu_id', 'id_regu');
    }

    /**
     * Relasi one-to-many ke LaporanHarian (Laporan yang dibuat user).
     */
    public function laporanHarian(): HasMany
    {
        return $this->hasMany(LaporanHarian::class, 'user_id', 'id');
    }

    /**
     * Relasi one-to-many ke KeteranganLaporanHarian (Laporan yang diverifikasi oleh user ini).
     */
    public function laporanVerifikasi(): HasMany
    {
        return $this->hasMany(KeteranganLaporanHarian::class, 'pengawas_id', 'id');
    }

    /**
     * Relasi one-to-one ke Regu (Jika user ini adalah Karu).
     */
    public function kepalaReguDi(): HasOne
    {
        return $this->hasOne(Regu::class, 'karu', 'id');
    }
}
