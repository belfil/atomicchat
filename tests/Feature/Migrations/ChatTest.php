<?php

namespace Belfil\AtomicChat\Tests\Feature\Migrations;

use Belfil\AtomicChat\Tests\Helpers\Database;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class ChatTest extends TestCase
{
    use Database;

    public function test_create_table_with_default_table_name()
    {
        $tableName = config('atomic-chat.tables.chats.name');
        $this->assert($tableName);
    }

    public function test_create_table_with_new_table_name()
    {
        $tableName = 'custom_chats_table';
        config(['atomic-chat.tables.chats.name' => $tableName]);
        $this->migrateFresh();
        $this->assert($tableName);
    }

    private function assert($table)
    {
        $this->assertTrue(Schema::hasTable($table));
        $this->assertEqualColumns($table, [
            'id',
            'uuid',
            'type',
            'title',
            'created_at',
            'updated_at'
        ]);
        $this->assertIndexExists($table, $table . '_unique_uuid');
    }
}