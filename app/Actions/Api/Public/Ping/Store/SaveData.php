<?php

namespace App\Actions\Api\Public\Ping\Store;

use App\Models\Device;
use App\Models\PingServer;
use Illuminate\Http\Request;

class SaveData
{
    public static function handle(Request $request)
    {
        $device = Device::where('name', $request->name)->first();

        PingServer::create([
            'date_time' => now(),
            'device_id' => $device->id
        ]);
    }
}
