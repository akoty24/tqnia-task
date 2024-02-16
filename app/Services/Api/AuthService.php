<?php
namespace App\Services\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\VerfyRequest;
use App\Http\Requests\Api\VerifyRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthService
{

    use ApiResponseTrait;  

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        $user->otp = rand(100000, 999999);
        $user->save();

        Log::info("Verification code for user {$user->id}: {$user->otp}");
        
        $data = [
            'user' => new UserResource($user),
            'otp' => $user->otp,
        ];
        return $this->successResponse('Please verify your account',$data, 401);
    }

    public function SendOTP($mobile_number, $password){
        $user = User::where('mobile_number', $mobile_number)->first();
        if (!$user) {
            return false;
        }
        $user->otp = rand(100000, 999999);
        $user->save();
        Log::info("Verification code for user {$user->id}: {$user->otp}");
        return $user->otp;

    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('mobile_number', $validatedData['mobile_number'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'mobile_number' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        if (!$user->is_verified) {
            return $this->errorResponse('Please verify your account', 401);
        }
        $data = [
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
              
        ];
    
        return $this-> successResponse('Login successful',  $data, 200);
    }

    public function verify(VerifyRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('mobile_number', $validatedData['mobile_number'])
                    ->where('otp', $validatedData['otp'])
                    ->first();

        if (!$user) {
            return $this->errorResponse('Invalid verification code', 400);

        }

        $user->is_verified = true;
        $user->otp = null;
        $user->save();
        $data = [
            'user' => $user,
            'access_token' => $user->createToken('auth_token')->plainTextToken,
        ];
        return $this->successResponse('Account verified successfully',$data, 200);
    
    }
}

