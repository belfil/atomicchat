<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Tests\Feature\Stream;

use Belfil\AtomicChat\Stream\Models\StreamChat;
use Belfil\AtomicChat\Stream\Models\StreamMessage;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StreamMessageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create()
    {
        $chat = StreamChat::new()->save();
        collect([
            [
                'message' => fn() => $chat->message()->save(),
                'expected' => ['chat_id' => $chat->id, 'content' => ''],
            ],
            [
                'message' => fn() => StreamMessage::new()->content('foo')->chat($chat)->save(),
                'expected' => ['chat_id' => $chat->id, 'content' => 'foo'],
            ],
        ])->each(function(array $case, $name) {
            $message = $case['message']();
            $case['expected']['id'] = $message->id;
            $this->assert_message($case['expected'], $message, "case #$name");
        });
    }

    public function test_edit()
    {
        $chat = StreamChat::new()->save();
        collect([
            [
                'message' => fn() => $chat->message()->save(),
                'expected' => ['chat_id' => $chat->id, 'content' => 'bar'],
            ],
            [
                'message' => fn() => StreamMessage::new()->content('foo')->chat($chat)->save(),
                'expected' => ['chat_id' => $chat->id, 'content' => 'bar'],
            ],
        ])->each(function(array $case, $name) {
            /** @var StreamMessage $message */
            $message = $case['message']();
            $case['expected']['id'] = $message->id;
            $message->edit()->content($case['expected']['content'])->save();
            $this->assert_message($case['expected'], $message, "case #$name");
        });
    }

    public function test_count()
    {
        $total = 0;
        $chat1 = StreamChat::new()->save();
        $factory = fn() => StreamMessage::new()->content('foo')->chat($chat1)->save();
        $total += collect()->times(2, $factory)->count();
        $chat2 = StreamChat::new()->save();
        $factory = fn() => StreamMessage::new()->content('foo')->chat($chat2)->save();
        $total += collect()->times(4, $factory)->count();
        $this->assert_message_count([$total, StreamMessage::query()], [2, $chat1->messages()], [4, $chat2->messages()]);
    }

    private function assert_message(array $expected, StreamMessage $message, string $note): void
    {
        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $message->$key, $note);
        }
        $this->assertDatabaseHas($message->getTable(), $expected);
    }

    private function assert_message_count(array ...$messages): void
    {
        foreach ($messages as $case => $query) {
            [$expected, $query] = $query;
            $this->assertEquals($expected, $query->count(), "case: $case");
        }
    }
}
