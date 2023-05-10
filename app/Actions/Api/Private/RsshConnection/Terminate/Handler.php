<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use App\Models\RsshLog;
use Illuminate\Http\Request;
use App\Models\RsshConnection;

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
            throw new \Exception($e->getMessage());
        }
    }
}
