<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'role' => [
            'driver' => 'daily',
            'path' => storage_path('logs/role.log')
        ],

        'user' => [
            'driver' => 'daily',
            'path' => storage_path('logs/user.log')
        ],

        'authentication' => [
            'driver' => 'daily',
            'path' => storage_path('logs/authentication.log')
        ],

        'useraction' => [
            'driver' => 'daily',
            'path' => storage_path('logs/useraction.log')
        ],

        'listener' => [
            'driver' => 'daily',
            'path' => storage_path('logs/listener.log')
        ],

        'tax' => [
            'driver' => 'daily',
            'path' => storage_path('logs/tax.log')
        ],

        'topic' => [
            'driver' => 'daily',
            'path' => storage_path('logs/topic.log')
        ],

        'course' => [
            'driver' => 'daily',
            'path' => storage_path('logs/course.log')
        ],

        'question' => [
            'driver' => 'daily',
            'path' => storage_path('logs/question.log')
        ],

        'document' => [
            'driver' => 'daily',
            'path' => storage_path('logs/document.log')
        ],

        'crypto' => [
            'driver' => 'daily',
            'path' => storage_path('logs/crypto.log')
        ],

        'order' => [
            'driver' => 'daily',
            'path' => storage_path('logs/order.log')
        ],

        'test' => [
            'driver' => 'daily',
            'path' => storage_path('logs/test.log')
        ],

        'channel' => [
            'driver' => 'daily',
            'path' => storage_path('logs/channel.log')
        ],

        'menu' => [
            'driver' => 'daily',
            'path' => storage_path('logs/menu.log')
        ],

        'footer' => [
            'driver' => 'daily',
            'path' => storage_path('logs/footer.log')
        ],

        'page' => [
            'driver' => 'daily',
            'path' => storage_path('logs/page.log')
        ],

        'section' => [
            'driver' => 'daily',
            'path' => storage_path('logs/section.log')
        ],

        'collection' => [
            'driver' => 'daily',
            'path' => storage_path('logs/collection.log')
        ],

        'thread' => [
            'driver' => 'daily',
            'path' => storage_path('logs/thread.log')
        ],

        'misc' => [
            'driver' => 'daily',
            'path' => storage_path('logs/misc.log')
        ],

        'enquiry' => [
            'driver' => 'daily',
            'path' => storage_path('logs/enquiry.log')
        ],

        'faq' => [
            'driver' => 'daily',
            'path' => storage_path('logs/faq.log')
        ],

        'activity' => [
            'driver' => 'daily',
            'path' => storage_path('logs/activity.log')
        ],

        'flag' => [
            'driver' => 'daily',
            'path' => storage_path('logs/flag.log')
        ],

        'chapter' => [
            'driver' => 'daily',
            'path' => storage_path('logs/chapter.log')
        ],

        'discount' => [
            'driver' => 'daily',
            'path' => storage_path('logs/discount.log')
        ],
    ],

];
