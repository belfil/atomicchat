<?php

declare(strict_types=1);

namespace Traits;

use Belfil\AtomicChat\Core\Models\CoreActor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property CoreActor|null $atomicActor
 */
trait AtomicActor
{
    public static function bootAtomicActor(): void
    {
        static::created(function($model) {
            $model->atomicActor()->create();
        });
    }

    public function asAtomicActor(): Model|CoreActor
    {
        if (!$this->atomicActor) {
            return $this->atomicActor()->firstOrCreate();
        }
        return $this->atomicActor;
    }

    public function atomicActor(): MorphOne
    {
        return $this->morphOne(config('atomic-chat.core.models.actor.class'), 'actorable');
    }
}
