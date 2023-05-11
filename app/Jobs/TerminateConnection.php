<?php

namespace App\Jobs;

use Log;
use App\Models\RsshLog;
use Illuminate\Bus\Queueable;
use App\Models\RsshConnection;
use App\Models\ConnectionStatus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TerminateConnection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deviceId;

    /**
     * Create a new job instance.
     */
    public function __construct($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $rsshConnection = RsshConnection::where('device_id', $this->deviceId)->first();
        if ($rsshConnection) {
            try {
                $this->disconnect();
                $this->updateStatusConnection();
                $this->createLog($rsshConnection);
            } catch (\Exception $e) {
                RsshLog::create([
                    'log' => $e->getMessage(),
                    'rssh_connection_id' => $rsshConnection->id
                ]);
            }
        }
    }

    public function disconnect()
    {
        $rsshConnection = RsshConnection::where('device_id', $this->deviceId)->first();
        $port = (int) $rsshConnection->server_port;
        exec("lsof -i :$port -t", $outputLsof, $resultLsof);

        Log::info($resultLsof);
        Log::info($outputLsof);
        if ($resultLsof == 0) {
            if (is_array($outputLsof)) {
                if (count($outputLsof) > 0) {
                    $pid = (int) $outputLsof[0];
                    exec("kill -9 $pid", $outputKill, $resultKill);
                    if ($resultKill !== 0)
                        throw new \Exception("Failed to terminate the process reverse ssh.");

                    return true;
                }
            }
        }

        throw new \Exception("Port $rsshConnection->server_port is not in use.");
    }

    public function updateStatusConnection()
    {
        RsshConnection::where('device_id', $this->deviceId)->update([
            'connection_status_id' => ConnectionStatus::where('name', 'terminate')->first()->id
        ]);
    }

    public function createLog($rsshConnection)
    {
        RsshLog::create([
            'log' => 'Success to terminate the process reverse ssh.',
            'rssh_connection_id' => $rsshConnection->id
        ]);
    }
}
