<?php

declare(strict_types=1);

namespace Group\Models;

use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Belfil\AtomicChat\Core\Models\CoreMember;
use Belfil\AtomicChat\Stream\Builders\CoreMessageBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property string $type
 * @property string|null $hash
 * @property Collection $members
 */
class Chat extends Model implements Atomicable
{
    protected $guarded = [];

    protected $attributes = [
        'type' => 'stream',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('atomic-chat.core.models.chat.table');
    }

    public function members()
    {
        return $this->hasMany(CoreMember::class);
    }

    public function actors()
    {
        return $this
            ->belongsToMany(
                config('atomic-chat.core.models.actor.class'),
                config('atomic-chat.core.models.member.table'),
                'chat_id',
                'actor_id'
            )
            ->using(config('atomic-chat.core.models.member.class'))
            ->withPivot('last_read_id')
            ->withTimestamps();
    }

    public function atomicId(): int
    {
        return $this->id;
    }

    public function scopeByHash($query, string $hash)
    {
        $query->where('hash', $hash);
    }

    public function message()
    {
        return app(CoreMessageBuilder::class, ['chat' => $this]);
    }
}
