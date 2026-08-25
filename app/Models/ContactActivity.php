<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_message_id',
        'user_id',
        'type',
        'description',
    ];

    public function contactMessage()
    {
        return $this->belongsTo(ContactMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeColorAttribute()
    {
        return match ($this->type) {
            'message_created' => 'blue',
            'status_changed' => 'yellow',
            'reply_sent' => 'green',
            'note_added' => 'purple',
            'note_deleted' => 'red',
            default => 'gray',
        };
    }

    public function getTypeIconAttribute()
    {
        return match ($this->type) {
            'message_created' => 'message',
            'status_changed' => 'status',
            'reply_sent' => 'reply',
            'note_added' => 'note',
            'note_deleted' => 'delete',
            default => 'activity',
        };
    }
}