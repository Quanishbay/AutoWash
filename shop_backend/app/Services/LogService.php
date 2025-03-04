<?php

namespace App\Services;

use App\Models\Log;

class LogService
{
    public function log($level, $user_id, $user_role, $message, $context = null)
    {
        Log::create([
            'level' => $level,
            'user_id' => $user_id,
            'role' => $user_role,
            'message' => $message
        ]);
    }
}
