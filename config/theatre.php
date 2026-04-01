<?php

return [
    'reservation_timeout' => env('THEATRE_RESERVATION_TIMEOUT', 1800), // 30 минут в секундах
    'payment_timeout' => env('THEATRE_PAYMENT_TIMEOUT', 1800), // 30 минут
];