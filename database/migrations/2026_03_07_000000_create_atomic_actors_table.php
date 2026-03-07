<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const CONFIG_KEY = 'atomic-chat.tables.actors';

    public function up(): void
    {
        $tableSettings = config(self::CONFIG_KEY);
        $tableName = $tableSettings['name'];
        Schema::create($tableName, function (Blueprint $table) use ($tableName) {
            $table->id();
            $table->unsignedBigInteger('actorable_id');
            $table->string('actorable_type');
            $table->timestamps();
            $table->unique(['actorable_id', 'actorable_type'], $tableName . '_unique_actorable');
        });
    }

    public function down(): void
    {
        $tableSettings = config(self::CONFIG_KEY);
        Schema::dropIfExists($tableSettings['name']);
    }
};
