<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const CONFIG_KEY = 'atomic-chat.tables.chats';

    public function up(): void
    {
        $tableSettings = config(self::CONFIG_KEY);
        $tableName = $tableSettings['name'];
        Schema::create($tableName, function (Blueprint $table) use ($tableName) {
            $table->id();
            $table->uuid()->unique($tableName . '_unique_uuid');
            $table->string('type')->default('private');
            $table->string('title')->default('');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $tableSettings = config(self::CONFIG_KEY);
        Schema::dropIfExists($tableSettings['name']);
    }
};

