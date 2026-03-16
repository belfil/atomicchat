<?php

declare(strict_types=1);

namespace Stubs\Models;

use Illuminate\Database\Eloquent\Model;
use Traits\AtomicActor;

class User extends Model
{
    use AtomicActor;
}
