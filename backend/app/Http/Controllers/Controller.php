<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function jsonResponse($data = null, $message = null, $errors = [], $success = true, $statusCode = 200)
    {
        return response()->json([
            'success' => $success,
            'errors' => $errors,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
