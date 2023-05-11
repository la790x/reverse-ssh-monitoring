<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

use Illuminate\Http\Request;
use App\Jobs\TerminateConnection;

class Handler
{
    public function handle(Request $request, $id)
    {
        try {
            $request->request->add([
                'device_id' => $id
            ]);
            ValidateRequest::handle($request);
            UpdateData::handle($request);
            dispatch(new TerminateConnection($id));
            return response()->api(true, 200, [], 'Successfully send a disconnect connection request', '', '');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
