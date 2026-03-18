<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const CONFIG_TABLE_NAME = 'atomic-chat.models.chat.table';

    public function up(): void
    {
        $tableName = config(self::CONFIG_TABLE_NAME);
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
        Schema::dropIfExists(config(self::CONFIG_TABLE_NAME));
    }
};
