<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data = [], $message = 'Data found', $code = 200) 
    {
        $response = [
            'data' => $data,
            'message' => $message
        ];

        return response()->json($response, $code);
    }

    public function sendCollectionResource($resource, $message = 'Collections found', $code = 200)
    {
        $response = [
            'data' => $resource,
            'message' => $message
        ];

        return response()->json($response, $code);
    }

    public function sendError($error, $code = 404)
    {
        $response = [
            'message' => $error
        ];

        return response()->json($response, $code);
    }
}
