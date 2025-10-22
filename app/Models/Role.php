<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table      = 'roles';   // Nama tabel
    protected $primaryKey = 'role_id'; // Primary key
    public $incrementing  = false;     // Karena kita tidak pakai auto-increment

    protected $fillable = [
        'role_id',
        'nm_role',
    ];

    /**
     * Relasi one-to-many ke User.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}
