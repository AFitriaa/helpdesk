<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'unit_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

        // Relasi ke tickets yang dibuat user
        public function ticketsCreated()
        {
            return $this->hasMany(Ticket::class, 'created_by');
        }

        // Relasi ke tickets yang ditugaskan ke user (agent)
        public function ticketsAssigned()
        {
            return $this->hasMany(Ticket::class, 'assigned_to');
        }

        // Relasi ke unit (opsional)
        public function unit()
        {
            return $this->belongsTo(Unit::class);
        }
}
