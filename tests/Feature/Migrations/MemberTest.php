<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Tests\Feature\Migrations;

use Belfil\AtomicChat\Tests\Helpers\Database;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class MemberTest extends TestCase
{
    use Database;

    public function test_create_members_table_with_default_name(): void
    {
        $table = config('atomic-chat.tables.members.name');
        $this->assertMemberStructure($table);
    }

    public function test_create_members_table_with_custom_name(): void
    {
        $table = 'custom_chat_members';
        config(['atomic-chat.tables.members.name' => $table]);
        $this->migrateFresh();
        $this->assertMemberStructure($table);
    }

    private function assertMemberStructure(string $table): void
    {
        $this->assertTrue(Schema::hasTable($table));
        $this->assertEqualColumns($table, [
            'id',
            'chat_id',
            'actor_id',
            'last_read_id',
            'role',
            'created_at',
            'updated_at',
        ]);
        $this->assertIndexExists($table, $table . '_unique_actor_id_chat_id');
    }
}
