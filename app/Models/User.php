<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'unit_kerja',
        'vendor_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class, 'requested_by');
    }

    public function approvedPurchaseRequests()
    {
        return $this->hasMany(PurchaseRequest::class, 'approved_by');
    }

    // Role helper

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isApprover(): bool
    {
        return $this->role === 'approver';
    }

    public function isProcurement(): bool
    {
        return $this->role === 'procurement';
    }

    public function isVendor(): bool
    {
        return $this->role === 'vendor';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}
