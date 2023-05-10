<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use Illuminate\Http\Request;

class ValidateRequest
{
    public static function handle(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:rssh_connections,device_id'
        ]);
    }
}
