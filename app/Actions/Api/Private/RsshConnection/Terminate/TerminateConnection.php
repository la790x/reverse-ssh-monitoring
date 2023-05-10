<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use App\Models\RsshLog;
use Illuminate\Http\Request;
use App\Models\RsshConnection;
use App\Models\ConnectionStatus;

class TerminateConnection
{
    public static function handle(Request $request)
    {
        $rsshConnection = RsshConnection::where('device_id', $request->device_id)->first();
        $request->request->add([
            'rss_connection' => $rsshConnection
        ]);

        self::execute($request);
        self::updateStatusConnection($request);
        self::createLog($request);
    }

    public static function execute($request)
    {
        $rsshConnection = app('request')->rss_connection;
        $port = (int) $rsshConnection->server_port;
        exec("lsof -i :$port -t", $outputLsof, $resultLsof);

        dump($resultLsof);
        if ($resultLsof === 0) {
            if (is_array($outputLsof)) {
                if (count($outputLsof) > 0) {
                    $pid = $outputLsof[0];
                    dump($pid);
                    exec("kill -9 $pid", $outputKill, $resultKill);
                    if ($resultKill !== 0)
                        throw new \Exception("Failed to terminate the process reverse ssh.");

                    return true;
                }
            }
        }

        throw new \Exception("Port $rsshConnection->server_port is not in use.");
    }

    public function updateStatusConnection($request)
    {
        RsshConnection::where('device_id', $request->device_id)->update([
            'connection_status_id' => ConnectionStatus::where('name', 'terminate')->first()->id
        ]);
    }

    public static function createLog($request)
    {
        $rsshConnection = app('request')->rss_connection;
        RsshLog::create([
            'log' => 'Success to terminate the process reverse ssh.',
            'rssh_connection_id' => $rsshConnection->id
        ]);
    }
}
