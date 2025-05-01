<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message_id' => $this->message_id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message_text' => $this->message_text,
            'message_type' => $this->message_type,
            'attachment_url' => $this->attachment_url,
            'is_read' => $this->is_read ?? 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sent_at' => optional($this->created_at)->format('Y-m-d H:i:s'),
            'entity_type' => $this->entity_type,
            'entity_id' => $this->entity_id,
            'is_deleted' => $this->is_deleted ?? 0,
            'deleted_at' => $this->deleted_at,

            'sender' => $this->sender ? [
                'sender_id' => $this->sender->user_id,
                'name' => trim($this->sender->first_name . ' ' . $this->sender->last_name),
                'email' => $this->sender->email,
                'avatar' => $this->sender->avatar ? Storage::disk('public')->url('profile_pictures/' . $this->sender->avatar) : null,
            ] : null,

            'receiver' => $this->receiver ? [
                'receiver_id' => $this->receiver->user_id,
                'name' => trim($this->receiver->first_name . ' ' . $this->receiver->last_name),
                'email' => $this->receiver->email,
                'avatar' => $this->receiver->avatar ? Storage::disk('public')->url('profile_pictures/' . $this->receiver->avatar) : null,
            ] : null,
            'Last Message' =>
                [
                    'last_message' => $this->lastMessage ? new ChatMessageResource($this->lastMessage) : null,
                ]
        ];
    }
}
