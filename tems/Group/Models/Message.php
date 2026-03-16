<?php

declare(strict_types=1);

namespace Group\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $content
 * @property int $chat_id
 * @property int|null $actor_id
 */
class Message extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('atomic-chat.core.models.message.table');
    }
}
