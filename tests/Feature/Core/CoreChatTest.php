<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Tests\Feature\Core;

use Belfil\AtomicChat\Core\Models\CoreChat;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoreChatTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create()
    {
        collect([
            [
                'chat' => fn() => CoreChat::new()->save(),
                'expected' => [],
            ],
        ])->each(function(array $case, $name) {
            $chat = $case['chat']();
            $case['expected']['id'] = $chat->id;
            $this->assert_chat($case['expected'], $chat, "case #$name");
        });
    }

    public function test_edit()
    {
        collect([
            [
                'chat' => fn() => CoreChat::new()->save(),
                'expected' => [],
            ],
        ])->each(function(array $case, $name) {
            $chat = $case['chat']();
            $case['expected']['id'] = $chat->atomicId();
            $chat->edit()->save();
            $this->assert_chat($case['expected'], $chat, "case #$name");
        });
    }

    public function test_count()
    {
        $total = 8;
        $factory = fn() => CoreChat::new()->save();
        collect()->times($total, $factory);
        $this->assert_chat_count([$total, CoreChat::query()]);
    }

    private function assert_chat(array $expected, CoreChat $message, string $note): void
    {
        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $message->$key, $note);
        }
        $this->assertDatabaseHas($message->getTable(), $expected);
    }

    private function assert_chat_count(array ...$chats): void
    {
        foreach ($chats as $case => $query) {
            [$expected, $query] = $query;
            $this->assertEquals($expected, $query->count(), "case: $case");
        }
    }
}
