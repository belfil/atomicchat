<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Contracts;

interface Atomicable
{
    public function atomicId(): int;
}
