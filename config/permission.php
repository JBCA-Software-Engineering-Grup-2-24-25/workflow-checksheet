<?php

return [
    'default' => [
        'index',
        'profile.avatar',
        'profile.update',
        'notification.index',
        'notification.show',
        'notification.update',
        'notification.destroy',
        'notification.readAll',
    ],

    'except'  => [
        'login',
        'logout',
        'register',
        'password.confirm',
        'password.update',
        'verification.send',
        'verification.verify',
        'verification.notice',
        'password.store',
        'password.reset',
        'password.email',
        'password.request',
        'ignition.updateConfig',
        'debugbar.openhandler',
        'debugbar.clockwork',
        'debugbar.assets.css',
        'debugbar.assets.js',
        'debugbar.cache.delete',
        'sanctum.csrf-cookie',
        'ignition.healthCheck',
        'ignition.executeSolution',
        'ignition.updateConfig',
    ],
];
