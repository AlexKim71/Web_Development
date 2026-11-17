<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoSession extends Model
{
    use HasFactory;

    protected $table = 'photo_sessions';

    protected $fillable = [
        'title',
        'description',
        'session_date',
        'duration',
        'type',
        'status',
        'client_id',
        'manager_id',
    ];

    protected $casts = [
        'session_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class)->onDelete('cascade');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id')->onDelete('cascade');
    }

    public function getStatusBadgeColor()
    {
        return match($this->status) {
            'нові' => 'primary',
            'в процесі' => 'warning',
            'завершено' => 'success',
            default => 'secondary'
        };
    }
}

