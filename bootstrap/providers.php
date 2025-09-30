<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\BroadcastServiceProvider::class,
    // Register Telescope only if the package is installed
    ...array_filter([
        class_exists(\Laravel\Telescope\TelescopeApplicationServiceProvider::class)
            ? App\Providers\TelescopeServiceProvider::class
            : null,
    ]),
];
