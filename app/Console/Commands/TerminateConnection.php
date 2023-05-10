<?php

namespace App\Console\Commands;

use App\Models\RsshLog;
use App\Models\RsshConnection;
use Illuminate\Console\Command;
use App\Models\ConnectionStatus;

class TerminateConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:terminate-connection {deviceId} {port}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $port = (int) $this->argument('port');
        $deviceId = (int) $this->argument('deviceId');
        $rsshConnection = RsshConnection::where('device_id', $deviceId)->first();

        try {
            self::execute($deviceId, $port);
            self::updateStatusConnection($deviceId);
            self::createLog($deviceId);
        } catch (\Exception $e) {
            RsshLog::create([
                'log' => $e->getMessage(),
                'rssh_connection_id' => $rsshConnection->id
            ]);
        }
    }

    public static function execute($deviceId, $port)
    {
        $rsshConnection = RsshConnection::where('device_id', $deviceId)->first();
        exec("lsof -i :$port -t", $outputLsof, $resultLsof);

        if ($resultLsof === 0) {
            if (is_array($outputLsof)) {
                if (count($outputLsof) > 0) {
                    $pid = $outputLsof[0];
                    exec("kill -9 $pid", $outputKill, $resultKill);
                    if ($resultKill !== 0)
                        return "Failed to terminate the process reverse ssh.";
                    return 'ok';
                }
            }
        }

        return "Port $rsshConnection->server_port is not in use.";
    }

    public static function updateStatusConnection($deviceId)
    {
        RsshConnection::where('device_id', $deviceId)->update([
            'connection_status_id' => ConnectionStatus::where('name', 'terminate')->first()->id
        ]);
    }

    public static function createLog($deviceId)
    {
        $rsshConnection = RsshConnection::where('device_id', $deviceId)->first();
        RsshLog::create([
            'log' => 'Success to terminate xthe process reverse ssh.',
            'rssh_connection_id' => $rsshConnection->id
        ]);
    }
}