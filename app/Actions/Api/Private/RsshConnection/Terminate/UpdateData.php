<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use App\Models\RsshLog;
use Illuminate\Http\Request;
use App\Models\RsshConnection;
use App\Models\ConnectionStatus;

class UpdateData
{
    public static function handle(Request $request)
    {
        $rsshConnection = RsshConnection::where('device_id', $this->deviceId)->first();
        RsshConnection::where('device_id', $this->deviceId)->update([
            'connection_status_id' => ConnectionStatus::where('name', 'request terminate')->first()->id
        ]);
        RsshLog::create([
            'log' => 'request terminate connection ip ' . $rsshConnection->server_ip . ' port ' . $rsshConnection->server_port,
            'rssh_connection_id' => $rsshConnection->id
        ]);
    }
}
