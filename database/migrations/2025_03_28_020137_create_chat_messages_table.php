<?php

use App\Enums\MessageEntityType;
use App\Enums\MessageType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->text('message_text')->nullable()->default(null);
            $table->enum('message_type', MessageType::values());
            $table->string('attachment_url', 255)->nullable()->default(null);
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->timestamp('sent_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('read_at')->nullable()->default(null);
            $table->enum('entity_type', MessageEntityType::values())->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->softDeletes();
            $table->foreign('sender_id')->references('id')
                ->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
