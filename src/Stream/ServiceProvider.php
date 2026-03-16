<?php

declare(strict_types=1);

namespace Belfil\AtomicChat\Stream;

use Belfil\AtomicChat\Core\Builders\CoreChatBuilder;
use Belfil\AtomicChat\Core\Builders\CoreMessageBuilder;
use Belfil\AtomicChat\Stream\Builders\StreamChatBuilder;
use Belfil\AtomicChat\Stream\Builders\StreamMessageBuilder;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(StreamChatBuilder::class, function($app, $params) {
            $coreChatBuilder = app(CoreChatBuilder::class, ['chat' => $params['chat']]);
            return new StreamChatBuilder($coreChatBuilder);
        });
        $this->app->bind(StreamMessageBuilder::class, function($app, $params) {
            $coreMessageBuilder = app(CoreMessageBuilder::class, ['message' => $params['message']]);
            return new StreamMessageBuilder($coreMessageBuilder);
        });
    }
}
