<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use Illuminate\Http\Request;
use App\Models\RsshConnection;

class TerminateConnection
{
    public static function handle(Request $request)
    {
        $rsshConnection = RsshConnection::where('device_id', $request->device_id)->first();
        $request->request->add([
            'rss_connection_id' => $rsshConnection->id
        ]);
        exec("lsof -i :$rsshConnection->server_port -t", $outputLsof, $resultLsof);

        if ($resultLsof === 0) {
            if (is_array($outputLsof)) {
                if (count($outputLsof) > 0) {
                    $pid = $outputLsof[0];
                    exec("kill -9 $pid", $outputKill, $resultKill);
                    if ($resultKill !== 0)
                        throw new \Exception("Failed to terminate the process.");

                    return true;
                }
            }
        }

        throw new \Exception("Port $port is not in use.");
    }
}
