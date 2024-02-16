<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\VerifyOTPRequest;
use App\Http\Requests\Api\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Api\AuthService;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }

    public function login(LoginRequest $request)
    {

        return $this->authService->login($request);
    }

    public function verify(VerifyRequest $request)
    {
        return $this->authService->verify($request);
    }
}
//     public function register(RegisterRequest $request)
// {
//     $data = $request->validated();
    
//     if ($data['password'] != $data['password_confirmation']) {
//         return $this->errorResponse('Password and password confirmation do not match', 400);
//     }
    
//     if (User::where('mobile_number', $data['mobile_number'])->exists()) {
//         return $this->errorResponse('User already exists', 400);
//     }        

//     // Generate and send OTP
//     $otp = $this->authService->SendOTP($data['mobile_number'], $data['password']);
//     dd ($otp);

//     if (!$otp) {
//         return $this->errorResponse('Failed to send OTP', 500);
//     }
//     return $this->successResponse('OTP sent successfully');
// }

//     public function login(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'mobile_number' => 'required',
//             'password' => 'required',
//         ]);
    
//         if ($validator->fails()) {
//             return $this->errorResponse($validator->errors()->first(), 401);
//         }
    
//         // Generate and send OTP
//         $otp = $this->authService->SendOTP($request);
    
//         if (!$otp) {
//             return $this->errorResponse('Failed to send OTP', 500);
//         }
    
//         // Return success response indicating OTP sent
//         return $this->successResponse('OTP sent successfully');
//     }
    
//     public function verifyOTP(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'mobile_number' => 'required',
//             'otp' => 'required',
//         ]);
    
//         if ($validator->fails()) {
//             return $this->errorResponse($validator->errors()->first(), 401);
//         }
    
//         // Verify OTP
//         $verified = $this->authService->verifyOTP($request->all());
    
//         if (!$verified) {
//             return $this->errorResponse('Invalid OTP', 401);
//         }
    
//         // Log in the user
//         $user = $this->authService->loginUser($request->all());
    
//         if (!$user) {
//             return $this->errorResponse('Invalid credentials', 401);
//         }
    
//         // Prepare response data
//         $data = [
//             'user' => new UserResource($user),
//             'token' => $user->createToken('auth_token')->plainTextToken,
//         ];
    
//         return $this->successResponse('Login successful', $data);
//     }



















//     public function login(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'mobile_number' => 'required',
//         'password' => 'required',
//     ]);

//     if ($validator->fails()) {
//         return $this->errorResponse($validator->errors()->first(), 401);
//     }
//     $user = $this->authService->loginUser($request);
//     if (!$user) {
//         return $this->errorResponse('Invalid credentials', 401);
//     }

//     $data = [
//         'user' => new UserResource($user),
//         'token' => $user->createToken('auth_token')->plainTextToken,
//     ];
    
// return $this->successResponse('Login successful', $data);   
// }
//      public function verifyOTP(Request $request)
//      {
//         $data = $request->validated();

//         $user = $this->authService->verifyOTP($data);

//         if (!$user) {
//             return $this->errorResponse('Invalid OTP', 401);
//         }

//         $user = User::where('mobile_number', $data['mobile_number'])->first();

//         if (!$user) {
//             return $this->errorResponse('User not found', 404);
//         }

//         if ($user) {
//             return $this->successResponse('OTP verified successfully');
//         } else {
//             return $this->errorResponse('Unauthorized', 401);
//         }
//      }

    
