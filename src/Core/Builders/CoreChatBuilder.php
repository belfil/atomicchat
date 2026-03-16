<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Builders;

use Belfil\AtomicChat\Core\Contracts\ChatBuildable;
use Belfil\AtomicChat\Core\Models\CoreChat;

class CoreChatBuilder implements ChatBuildable
{
    protected array $attributes = [];

    public function __construct(protected CoreChat $chat)
    {
    }

    public function build(): CoreChat
    {
        $this->chat->fill($this->attributes);
        return $this->chat;
    }

    public function save(): CoreChat
    {
        $this->chat->save();
        return $this->chat;
    }
}
