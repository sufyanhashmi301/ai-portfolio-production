<?php

namespace App\Http\Controllers\Api;

class HealthController
{
    public function __invoke(): array
    {
        return [
            'status' => 'ok',
            'service' => 'backend',
        ];
    }
}
