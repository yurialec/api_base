<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'email',
        'phone',
        'position',
        'status',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    // Funcionário com acesso ao sistema
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function hasSystemAccess(): bool
    {
        return !is_null($this->user_id);
    }
}
