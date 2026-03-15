<?php

declare(strict_types=1);

use Belfil\AtomicChat\Core\Models\CoreChat;
use Belfil\AtomicChat\Core\Models\CoreMessage;
use Belfil\AtomicChat\Stream\ServiceProvider;

return [
    /*
    |--------------------------------------------------------------------------
    | Core Entities
    |--------------------------------------------------------------------------
    */
    'core' => [
        'models' => [
            'actor' => [
                'table' => 'atomic_actors',
                'class' => null,
            ],
            'chat' => [
                'table' => 'atomic_chats',
                'class' => CoreChat::class,
            ],
            'message' => [
                'table' => 'atomic_messages',
                'class' => CoreMessage::class,
            ],
            'member' => [
                'table' => 'atomic_members',
                'class' => null,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Modules
    |--------------------------------------------------------------------------
    */
    'modules' => [
        'stream' => [
            'enabled' => true,
            'provider' => ServiceProvider::class,
        ],
    ],
];
