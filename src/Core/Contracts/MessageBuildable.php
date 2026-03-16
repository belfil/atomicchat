<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Contracts;

use Belfil\AtomicChat\Core\Models\CoreMessage;

interface MessageBuildable
{
    public function content(string $content): static;

    public function chat(Atomicable|int $id): static;

    public function build(): CoreMessage;

    public function save(): CoreMessage;
}
