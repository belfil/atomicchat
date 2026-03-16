<?php

declare(strict_types=1);

namespace Proxy;

use Belfil\AtomicChat\Core\Models\CoreActor;
use Private\Builders\PrivateChat;

class ChatProxy
{
    public function __construct(
        protected CoreActor $actor,
    ) {
    }

    public function private()
    {
        return app(PrivateChat::class);
    }
}
