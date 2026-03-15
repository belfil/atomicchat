<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const CONFIG_TABLE_NAME = 'atomic-chat.core.models.actor.table';

    public function up(): void
    {
        $tableName = config(self::CONFIG_TABLE_NAME);
        Schema::create($tableName, function(Blueprint $table) use ($tableName) {
            $table->id();
            $table->unsignedBigInteger('actorable_id');
            $table->string('actorable_type');
            $table->timestamps();
            $table->unique(['actorable_id', 'actorable_type'], $tableName . '_unique_actorable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config(self::CONFIG_TABLE_NAME));
    }
};
