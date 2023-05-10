<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use App\Models\RsshLog;
use Illuminate\Http\Request;

class Handler
{
    public function handle(Request $request, $id)
    {
        try {
            $request->request->add([
                'device_id' => $id
            ]);
            ValidateRequest::handle($request);
            TerminateConnection::handle($request);
            return response()->api(true, 200, [], 'Successfully terminated connection', '', '');
        } catch (\Exception $e) {
            $rsshConnection = request()->rss_connection;
            RsshLog::create([
                'log' => $e->getMessage(),
                'rss_connection_id' => $rsshConnection->id
            ]);
            throw new \Exception($e->getMessage());
        }
    }
}
