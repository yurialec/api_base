<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // Funcionários SEM acesso ao sistema
    public function employeesWithoutAccess()
    {
        return $this->hasMany(Employee::class)->whereNull('user_id');
    }

    // Funcionários COM acesso ao sistema
    public function employeesWithAccess()
    {
        return $this->hasMany(Employee::class)->whereNotNull('user_id');
    }
}
