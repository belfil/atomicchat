<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Stream\Builders;

use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Belfil\AtomicChat\Core\Contracts\MessageBuildable;
use Belfil\AtomicChat\Stream\Models\StreamMessage;

class StreamMessageBuilder implements MessageBuildable
{
    protected array $attributes = [];

    public function __construct(
        protected MessageBuildable $builder
    ) {
    }

    public function chat(Atomicable|int $id): static
    {
        $this->builder->chat($id);
        return $this;
    }

    public function content(string $content): static
    {
        $this->builder->content($content);
        return $this;
    }

    public function build(): StreamMessage
    {
        /** @var StreamMessage $message */
        $message = $this->builder->build();
        $message->fill($this->attributes);
        return $message;
    }

    public function save(): StreamMessage
    {
        /** @var StreamMessage $message */
        $message = $this->builder->save();
        return $message;
    }
}
