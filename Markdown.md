# Laravel Chat Application

## Overview
This Laravel application manages chat messages between users using Laravel Echo, Pusher, and WebSockets for real-time updates.

## Components

### Event Broadcasting
The `MessageSentEvent` broadcasts new chat messages using private channels based on sender and receiver IDs.

### Controllers
#### `ChatMessageController`
- **`sendMessage`**: Handles sending messages between users.
- **`getChatHistory`**: Retrieves chat history for a specific user.
- **`markAsRead`**: Marks messages as read for a user.
- **`contacts`**: Retrieves contacts for a user.
- **`getAllChats`**: Retrieves all chat messages.

### Resources
#### `ChatMessageResource`
- Transforms `ChatMessage` model data into JSON responses, including sender and receiver information.

### Requests
#### `SendMessageRequest`
- Validates and handles requests to send messages, ensuring sender and receiver IDs are valid and different.

### Interfaces
#### `ChatMessageInterface`
- Defines methods for managing chat messages.

### Repositories
#### `ChatMessageRepository`
- Implements `ChatMessageInterface` methods using Eloquent models for database operations.

### Services
#### `ChatMessageService`
- Orchestrates message sending, broadcasting, and retrieval operations using the repository.

## Frontend Integration
The frontend uses Laravel Echo and Pusher to listen for new messages and update the UI in real-time.

## Setup
1. Clone the repository.
2. Install dependencies: `composer install` and `npm install`.
3. Configure `.env` for database and Pusher settings.
4. Run migrations: `php artisan migrate`.
5. Compile frontend assets: `npm run dev`.

## Usage
1. Register/login users.
2. Start sending messages between users.
3. View chat history, mark messages as read, and manage contacts.

