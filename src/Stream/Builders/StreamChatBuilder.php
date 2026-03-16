<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Stream\Builders;

use Belfil\AtomicChat\Core\Contracts\ChatBuildable;
use Belfil\AtomicChat\Stream\Models\StreamChat;

class StreamChatBuilder implements ChatBuildable
{
    protected array $attributes = [
        'type' => 'stream',
    ];

    public function __construct(protected ChatBuildable $builder)
    {
    }

    public function build(): StreamChat
    {
        /** @var StreamChat $chat */
        $chat = $this->builder->build();
        $chat->fill($this->attributes);
        return $chat;
    }

    public function save(): StreamChat
    {
        $chat = $this->build();
        $chat->save();
        return $chat;
    }
}
