<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Models;

use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Illuminate\Database\Eloquent\Model;

class CoreActor extends Model implements Atomicable
{
    protected $guarded = [];

    public function getTable()
    {
        return config('atomic-chat.core.models.actor.table');
    }

    public function atomicId(): int
    {
        return $this->id;
    }
}
