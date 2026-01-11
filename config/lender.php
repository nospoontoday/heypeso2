<?php

return [
    'default_reapplication_cooldown_days' => env('DEFAULT_REAPPLICATION_COOLDOWN_DAYS', 30),
    'minimum_reapplication_cooldown_days' => env('MINIMUM_REAPPLICATION_COOLDOWN_DAYS', 7),
    'maximum_reapplication_cooldown_days' => env('MAXIMUM_REAPPLICATION_COOLDOWN_DAYS', 365),
];