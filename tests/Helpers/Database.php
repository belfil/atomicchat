<?php

namespace Belfil\AtomicChat\Tests\Helpers;

use Illuminate\Support\Facades\Schema;

trait Database
{
    protected function assertEqualColumns(string $table, array $expected): void
    {
        $actualColumns = Schema::getColumns($table);
        $actual = array_column($actualColumns, 'name');
        sort($actual);
        sort($expected);
        $this->assertEquals($expected, $actual);
    }

    protected function assertIndexExists(string $table, string $name): void
    {
        $indexes = collect(Schema::getIndexes($table))->pluck('name');
        $this->assertTrue($indexes->contains($name), "Index [{$name}] not found on table [{$table}]. Indexes: [{$indexes}]]");
    }

    protected function migrateFresh()
    {
        $this->artisan('migrate:fresh', [
            '--path' => __DIR__ . '/../../database/migrations',
            '--realpath' => true,
        ]);
    }
}