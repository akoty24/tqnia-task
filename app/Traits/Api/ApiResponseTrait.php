<?php
 namespace App\Traits\Api;

 trait ApiResponseTrait
 {
     protected function successResponse(string $message, ?array $data = null, int $statusCode = 200)
     {
         return response()->json([
             'success' => true,
             'message' => $message,
             'data' => $data,
         ], $statusCode);
     }

     protected function errorResponse(string $message, int $statusCode)
     {
         return response()->json([
             'success' => false,
             'message' => $message,
         ], $statusCode);
     }

}