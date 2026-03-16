<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Tests\Feature\Stream;

use Belfil\AtomicChat\Stream\Models\StreamChat;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StreamChatTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create()
    {
        collect([
            [
                'chat' => fn() => StreamChat::new()->save(),
                'expected' => ['type' => 'stream'],
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
                'chat' => fn() => StreamChat::new()->save(),
                'expected' => ['type' => 'stream'],
            ],
        ])->each(function(array $case, $name) {
            /** @var StreamChat $chat */
            $chat = $case['chat']();
            $case['expected']['id'] = $chat->atomicId();
            $chat->edit()->save();
            $this->assert_chat($case['expected'], $chat, "case #$name");
        });
    }

    public function test_count()
    {
        $total = 8;
        $factory = fn() => StreamChat::new()->save();
        collect()->times($total, $factory);
        $this->assert_chat_count([$total, StreamChat::query()]);
    }

    private function assert_chat(array $expected, StreamChat $message, string $note): void
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
