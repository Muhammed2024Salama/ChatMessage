<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $preventsLazyLoading = true;

    /**
     * @var string
     */
    protected $table = 'chat_messages';

    /**
     * @var string
     */
    protected $primaryKey = 'message_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message_text',
        'message_type',
        'attachment_url',
        'is_read',
        'sent_at',
        'read_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
