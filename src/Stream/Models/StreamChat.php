<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Stream\Models;

use Belfil\AtomicChat\Core\Contracts\ChatBuildable;
use Belfil\AtomicChat\Core\Contracts\MessageBuildable;
use Belfil\AtomicChat\Core\Models\CoreChat;
use Belfil\AtomicChat\Stream\Builders\StreamChatBuilder;

class StreamChat extends CoreChat
{
    public static function new(): ChatBuildable
    {
        return app(StreamChatBuilder::class, ['chat' => new self]);
    }

    public function edit(): ChatBuildable
    {
        return app(StreamChatBuilder::class, ['chat' => $this]);
    }

    public function message(): MessageBuildable
    {
        return StreamMessage::new()->chat($this);
    }
}
