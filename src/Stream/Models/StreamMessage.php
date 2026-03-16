<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Stream\Models;

use Belfil\AtomicChat\Core\Contracts\MessageBuildable;
use Belfil\AtomicChat\Core\Models\CoreMessage;
use Belfil\AtomicChat\Stream\Builders\StreamMessageBuilder;

class StreamMessage extends CoreMessage
{
    public static function new(): MessageBuildable
    {
        return app(StreamMessageBuilder::class, ['message' => new self]);
    }

    public function edit(): MessageBuildable
    {
        return app(StreamMessageBuilder::class, ['message' => $this])->chat($this->chat_id);
    }
}
