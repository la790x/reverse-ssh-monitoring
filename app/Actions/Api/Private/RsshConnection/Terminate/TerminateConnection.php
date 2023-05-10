<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use Illuminate\Http\Request;
use App\Models\RsshConnection;
use Illuminate\Support\Facades\Artisan;

class TerminateConnection
{
    public static function handle(Request $request)
    {
        $rsshConnection = RsshConnection::where('device_id', $request->device_id)->first();
        Artisan::call('app:terminate-connection', ['deviceid' => $rsshConnection->device_id,'port' => $rsshConnection->server_port]);

        $output = Artisan::output();
        if ('ok' != $output)
            throw new \Exception($output);
    }
}
