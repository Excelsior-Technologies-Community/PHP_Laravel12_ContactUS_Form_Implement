<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'mobile',
        'message',
        'status',
        'priority',
        'subject',
    ];

    protected $casts = [
        'status' => 'string',
        'priority' => 'string',
    ];

    public function replies()
    {
        return $this->hasMany(ContactReply::class);
    }

    public function notes()
    {
        return $this->hasMany(ContactNote::class);
    }

    public function activities()
    {
        return $this->hasMany(ContactActivity::class)
            ->latest();
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'new' => 'blue',
            'read' => 'yellow',
            'replied' => 'green',
            'closed' => 'gray',
            default => 'gray',
        };
    }

    public function getPriorityColorAttribute()
    {
        return match ($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray',
        };
    }
}