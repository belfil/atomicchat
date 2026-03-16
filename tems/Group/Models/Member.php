<?php

declare(strict_types=1);

namespace Group\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $chat_id
 */
class Member extends Pivot
{
    protected $guarded = [];

    public $incrementing = true;

    public $timestamps = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('atomic-chat.core.models.member.table');
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(config('atomic-chat.core.models.chat.class'), 'chat_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(config('atomic-chat.core.models.actor.class'), 'actor_id');
    }
}
