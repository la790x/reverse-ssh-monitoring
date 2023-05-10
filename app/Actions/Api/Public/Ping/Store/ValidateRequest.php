<?php

namespace App\Actions\Api\Public\Ping\Store;

use Illuminate\Http\Request;

class ValidateRequest
{
    public static function handle(Request $request)
    {
        $request->validate([
            'name' => 'required|exists:devices,name'
        ]);
    }
}
