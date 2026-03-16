<?php

declare(strict_types=1);

namespace Traits\Traits;

use Belfil\AtomicChat\Tests\Helpers\Database;
use Belfil\AtomicChat\Tests\Helpers\Models;
use Belfil\AtomicChat\Tests\TestCase;

class AtomicActorTest extends TestCase
{
    use Database;
    use Models;

    public function test_create_actor_after_created_user()
    {
        $this->createUser();
        $this->createUser();
        $this->assertDatabaseCount($this->actorTableName(), 2);
    }

    public function test_atomic_actor()
    {
        $this->assertNotNull($this->createActor());
    }

    public function test_as_atomic_actor()
    {
        $user = $this->createUser();
        $this->assertNotNull($user->asAtomicActor());
        $user->asAtomicActor()->delete();
        $user->refresh();
        $this->assertNotNull($user->asAtomicActor());
    }
}
