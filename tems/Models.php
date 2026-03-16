<?php

declare(strict_types=1);

use Belfil\AtomicChat\Core\Models\CoreActor;
use Stubs\Models\User;

trait Models
{
    protected function createUser(): User
    {
        return User::create();
    }

    protected function createActor(): CoreActor
    {
        return $this->createUser()->asAtomicActor();
    }
}
