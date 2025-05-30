<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * @return HasMany
     */
    public function chatMessagesSent()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id');
    }

    /**
     * @return HasMany
     */
    public function chatMessagesReceived()
    {
        return $this->hasMany(ChatMessage::class, 'receiver_id');
    }

    /**
     * @return HasOne
     */
    public function lastMessage(): HasOne
    {
        return $this->hasOne(ChatMessage::class, 'sender_id', 'user_id')
            ->latestOfMany('sent_at');
    }
}
