<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Tests\Feature\Migrations;

use Belfil\AtomicChat\Tests\Helpers\Database;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class ActorTest extends TestCase
{
    use Database;

    public function test_create_table_with_default_table_name()
    {
        $this->assert($this->actorTableName());
    }

    public function test_create_table_with_new_table_name()
    {
        $tableName = 'custom_actors_table';
        config(['atomic-chat.models.actor.table' => $tableName]);
        $this->migrateFresh();
        $this->assert($tableName);
    }

    private function assert($table)
    {
        $this->assertTrue(Schema::hasTable($table));
        $this->assertEqualColumns($table, [
            'id',
            'actorable_id',
            'actorable_type',
            'created_at',
            'updated_at',
        ]);
        $this->assertIndexExists($table, $table . '_unique_actorable');
    }
}
