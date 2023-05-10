<?php

namespace App\Actions\Api\Public\Ping\Store;

use Illuminate\Http\Request;

class Handler
{
    public function handle(Request $request)
    {
        try {
            ValidateRequest::handle($request);
            SaveData::handle($request);
            return response()->api(true, 200, [], 'Successfully store data', '', '');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
