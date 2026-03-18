<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const CONFIG_TABLE_NAME = 'atomic-chat.models.message.table';

    public function up(): void
    {
        $tableName = config(self::CONFIG_TABLE_NAME);
        Schema::create($tableName, function (Blueprint $table) use ($tableName) {
            $table->id();
            $table->unsignedBigInteger('chat_id')->index($tableName . '_chat_id_idx');
            $table->unsignedBigInteger('sender_id')->index($tableName . '_sender_id_idx');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config(self::CONFIG_TABLE_NAME));
    }
};
