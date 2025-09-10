<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by',
        'assigned_to',
        'unit_id',
        'category_id',
        'priority',
        'code',
        'sla_due_at',
        'attachments',
    ];

    // Relasi ke user pembuat tiket
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke agent
    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Relasi ke unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
