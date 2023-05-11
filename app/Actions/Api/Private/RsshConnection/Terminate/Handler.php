<?php

namespace App\Actions\Api\Private\RsshConnection\Terminate;

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
            UpdateData::handle($request);
            return response()->api(true, 200, [], 'Successfully send a disconnect connection request', '', '');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
