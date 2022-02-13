<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Zima Home",
     *      description="just be Your self"
     * )
     *
     */

    /**
     * @OA\Get(
     *     path="/",
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function successResponse($data, $messages = null, $statusCode = 200){
        return response()->json([
            'data' => [
                'status' => 'success',
                'messages' => $messages,
                'result' => $data,
                'code' => $statusCode
            ]
        ],$statusCode);
    }

    protected function customErrorResponse($data, $messages, $statusCode){
        return response()->json([
            'data' => [
                'status' => 'error',
                'messages' => $messages,
                'result' => $data,
                'code' => $statusCode
            ]
        ],$statusCode);
    }
}
