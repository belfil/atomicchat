<?php

declare(strict_types=1);

namespace tests\Private;

use Belfil\AtomicChat\Tests\Helpers\Database;
use Belfil\AtomicChat\Tests\Helpers\Models;
use Belfil\AtomicChat\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AtomicChatTest extends TestCase
{
    use Database;
    use DatabaseTransactions;
    use Models;

    public function test_create_private_chat()
    {
        $actor1 = $this->createActor();
        $actor2 = $this->createActor();
        $actor1->chat()->private()->to($actor2)->create();
        $actor1->chat()->private()->to($actor2)->firstOrCreate();
        $actor2->chat()->private()->to($actor1)->firstOrCreate();
        $this->assertEquals(1, $actor1->chats()->count());
        $this->assertEquals(1, $actor2->chats()->count());
    }

    public function test_send_message_to_private_chat()
    {
        $actor1 = $this->createActor();
        $actor2 = $this->createActor();

        $chat = $actor1->chat()->private()->to($actor2)->create();
        $chat->message()->actor($actor1)->create();
        $actor1->message()->chat($chat)->create();
        $this->assertEquals(1, $actor1->chats()->count());
        $this->assertEquals(1, $actor2->chats()->count());
    }
}
