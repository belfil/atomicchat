<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const CONFIG_TABLE_NAME = 'atomic-chat.models.member.table';

    public function up(): void
    {
        $tableName = config(self::CONFIG_TABLE_NAME);
        Schema::create($tableName, function (Blueprint $table) use ($tableName) {
            $table->id();
            $table->foreignId('chat_id');
            $table->foreignId('actor_id');
            $table->unsignedBigInteger('last_read_id')->default(0);
            $table->string('role')->default('creator');
            $table->timestamps();
            $table->unique(['actor_id', 'chat_id'], $tableName . '_unique_actor_id_chat_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config(self::CONFIG_TABLE_NAME));
    }
};
