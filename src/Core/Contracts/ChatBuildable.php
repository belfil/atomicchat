<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Contracts;

use Belfil\AtomicChat\Core\Models\CoreChat;

interface ChatBuildable
{
    public function build(): CoreChat;

    public function save(): CoreChat;
}
