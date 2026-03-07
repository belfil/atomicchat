<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const CONFIG_KEY = 'atomic-chat.tables.messages';

    public function up(): void
    {
        $tableSettings = config(self::CONFIG_KEY);
        $tableName = $tableSettings['name'];
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
        $tableSettings = config(self::CONFIG_KEY);
        Schema::dropIfExists($tableSettings['name']);
    }
};
