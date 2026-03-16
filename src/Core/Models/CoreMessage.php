<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Core\Models;

use Belfil\AtomicChat\Core\Builders\CoreMessageBuilder;
use Belfil\AtomicChat\Core\Contracts\MessageBuildable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $content
 * @property int $chat_id
 * @property int|null $actor_id
 */
class CoreMessage extends Model
{
    protected $guarded = [];

    public function getTable()
    {
        return config('atomic-chat.core.models.message.table');
    }

    public static function new(): MessageBuildable
    {
        return app(CoreMessageBuilder::class, ['message' => new self]);
    }

    public function edit(): MessageBuildable
    {
        return app(CoreMessageBuilder::class, ['message' => $this])->chat($this->chat_id);
    }
}
