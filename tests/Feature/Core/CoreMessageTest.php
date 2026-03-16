<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Tests\Feature\Core;

use Belfil\AtomicChat\Core\Models\CoreChat;
use Belfil\AtomicChat\Core\Models\CoreMessage;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoreMessageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create()
    {
        $chat = CoreChat::new()->save();
        collect([
            [
                'message' => fn() => $chat->message()->save(),
                'expected' => ['chat_id' => $chat->id, 'content' => ''],
            ],
            [
                'message' => fn() => CoreMessage::new()->content('foo')->chat($chat)->save(),
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
        $chat = CoreChat::new()->save();
        collect([
            [
                'message' => fn() => $chat->message()->save(),
                'expected' => ['chat_id' => $chat->id, 'content' => 'bar'],
            ],
            [
                'message' => fn() => CoreMessage::new()->content('foo')->chat($chat)->save(),
                'expected' => ['chat_id' => $chat->id, 'content' => 'bar'],
            ],
        ])->each(function(array $case, $name) {
            /** @var CoreMessage $message */
            $message = $case['message']();
            $case['expected']['id'] = $message->id;
            $message->edit()->content($case['expected']['content'])->save();
            $this->assert_message($case['expected'], $message, "case #$name");
        });
    }

    public function test_count()
    {
        $total = 0;
        $chat1 = CoreChat::new()->save();
        $factory = fn() => CoreMessage::new()->content('foo')->chat($chat1)->save();
        $total += collect()->times(2, $factory)->count();
        $chat2 = CoreChat::new()->save();
        $factory = fn() => CoreMessage::new()->content('foo')->chat($chat2)->save();
        $total += collect()->times(4, $factory)->count();
        $this->assert_message_count([$total, CoreMessage::query()], [2, $chat1->messages()], [4, $chat2->messages()]);
    }

    private function assert_message(array $expected, CoreMessage $message, string $note): void
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
