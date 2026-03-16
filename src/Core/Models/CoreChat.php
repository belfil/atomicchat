<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Models;

use Belfil\AtomicChat\Core\Builders\CoreChatBuilder;
use Belfil\AtomicChat\Core\Contracts\Atomicable;
use Belfil\AtomicChat\Core\Contracts\ChatBuildable;
use Belfil\AtomicChat\Core\Contracts\MessageBuildable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $type
 * @property string|null $hash
 * @property Collection $members
 */
class CoreChat extends Model implements Atomicable
{
    protected $guarded = [];

    public function getTable()
    {
        return config('atomic-chat.core.models.chat.table', 'atomic_chats');
    }

    public static function new(): ChatBuildable
    {
        return app(CoreChatBuilder::class, ['chat' => new self]);
    }

    public function edit(): ChatBuildable
    {
        return app(CoreChatBuilder::class, ['chat' => $this]);
    }

    public function message(): MessageBuildable
    {
        return CoreMessage::new()->chat($this);
    }

    public function atomicId(): int
    {
        return $this->id;
    }

    public function messages(): HasMany
    {
        return $this->hasMany(config('atomic-chat.core.models.message.class'), 'chat_id', 'id');
    }
}
