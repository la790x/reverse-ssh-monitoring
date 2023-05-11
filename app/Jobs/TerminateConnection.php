<?php

namespace App\Jobs;

use Log;
use App\Models\RsshLog;
use Illuminate\Bus\Queueable;
use App\Models\RsshConnection;
use App\Models\ConnectionStatus;
use mikehaertl\shellcommand\Command;
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
        $lsofPortCommand = new Command("lsof -i :$port -t");
        if ($lsofPortCommand->execute()) {
            $outputLsofPort = $lsofPortCommand->getOutput();
            Log::info($outputLsofPort);
        } else {
            throw new \Exception('error terminate port ' . $port . ' ' . $lsofPortCommand->getError());
        }
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
