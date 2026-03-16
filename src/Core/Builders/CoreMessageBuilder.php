<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Builders;

use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Belfil\AtomicChat\Core\Contracts\MessageBuildable;
use Belfil\AtomicChat\Core\Models\CoreMessage;

class CoreMessageBuilder implements MessageBuildable
{
    protected array $attributes = [];

    public function __construct(protected CoreMessage $message)
    {
    }

    public function chat(Atomicable|int $id): static
    {
        $this->attributes['chat_id'] = $id instanceof Atomicable ? $id->atomicId() : $id;
        return $this;
    }

    public function content(string $content): static
    {
        $this->attributes['content'] = $content;
        return $this;
    }

    public function build(): CoreMessage
    {
        $this->message->fill($this->attributes);
        return $this->message;
    }

    public function save(): CoreMessage
    {
        $message = $this->build();
        $message->save();
        return $message;
    }
}
