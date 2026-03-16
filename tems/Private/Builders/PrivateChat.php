<?php

declare(strict_types=1);

namespace Private\Builders;

use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Belfil\AtomicChat\Core\Models\CoreChat;

class PrivateChat
{
    protected int $sender;

    protected int $recipient;

    public function __construct(
        protected CoreChat $chat,
        Atomicable|int $sender
    ) {
        $this->sender = $sender instanceof Atomicable ? $sender->atomicId() : $sender;
    }

    public function to(Atomicable|int $recipient): static
    {
        $this->recipient = $recipient instanceof Atomicable ? $recipient->atomicId() : $recipient;
        return $this;
    }

    public function create(): CoreChat
    {
        return $this->save();
    }

    public function firstOrCreate(): CoreChat
    {
        $chat = $this->chat->newQuery()->byHash($this->generateHash())->first();
        return $chat ?? $this->create();
    }

    public function save(): CoreChat
    {
        $this->chat->hash = $this->generateHash();
        $this->chat->type = 'private';
        $this->chat->save();
        $this->chat->members()->createMany([
            ['actor_id' => $this->sender],
            ['actor_id' => $this->recipient],
        ]);
        return $this->chat;
    }

    public function generateHash(): string
    {
        if ($this->sender < $this->recipient) {
            return sprintf('%d|%d', $this->sender, $this->recipient);
        }
        return sprintf('%d|%d', $this->recipient, $this->sender);
    }
}
