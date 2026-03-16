<?php

declare(strict_types=1);

namespace Group\Builders;

use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Belfil\AtomicChat\Core\Models\CoreChat;

class GroupChat
{
    protected array $members = [];

    protected array $messages = [];

    public function __construct(
        protected CoreChat $chat,
    ) {
    }

    public function member(Atomicable|int $id): static
    {
        $id = $id instanceof Atomicable ? $id->atomicId() : $id;
        $this->members[$id] = ['actor_id' => $id];

        return $this;
    }

    public function save(): CoreChat
    {
        $this->chat->save();
        $this->saveMembers();
        $this->clear();
        return $this->chat;
    }

    public function create(): CoreChat
    {
        $this->chat->save();
        $this->createMembers();
        $this->clear();
        return $this->chat;
    }

    public function clear(): void
    {
        $this->members = [];
    }

    protected function saveMembers(): void
    {
        if (empty($this->members)) {
            return;
        }
        foreach ($this->members as $raw) {
            $this->chat->members()->updateOrCreate(
                ['actor_id' => $raw['actor_id']],
            );
        }
    }

    protected function createMembers(): void
    {
        if (empty($this->members)) {
            return;
        }
        $this->chat->members()->createMany(array_values($this->members));
    }
}
