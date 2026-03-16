<?php

declare(strict_types=1);

namespace Group\Models;

use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Belfil\AtomicChat\Proxy\ChatProxy;
use Belfil\AtomicChat\Stream\Builders\CoreMessageBuilder;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model implements Atomicable
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('atomic-chat.core.models.actor.table');
    }

    public function atomicId(): int
    {
        return $this->id;
    }

    public function chats()
    {
        return $this
            ->belongsToMany(
                config('atomic-chat.core.models.chat.class'),
                config('atomic-chat.core.models.member.table'),
                'actor_id',
                'chat_id'
            )
            ->using(config('atomic-chat.core.models.member.class'))
            ->withPivot('last_read_id')
            ->withTimestamps();
    }

    public function chat()
    {
        return app(ChatProxy::class, ['actor' => $this]);
    }

    public function message()
    {
        return app(CoreMessageBuilder::class)->actor($this);
    }
}
