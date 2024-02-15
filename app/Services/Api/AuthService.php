<?php
namespace App\Services\Api;

use App\Models\User;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthService
{

    use ApiResponseTrait;
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        $user->otp = rand(100000, 999999);
        $user->save();

        Log::info("Verification code for user {$user->id}: {$user->otp}");

        return response()->json(['user' => $user, 'message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        dd ($request->all());
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|max:20',
            'password' => 'required|string',
                ]);

                if ($validator->fails()) {
                 return $this->errorResponse($validator->errors()->first(), 401);
                   }
                   $user = User::where('mobile_number', $validator['mobile_number'])->first();
                           if ($user && Hash::check($validator['password'], $request->password)) {
                            if ($user->is_verified) {
                                $token = $user->createToken('auth_token')->plainTextToken;
                                return response()->json(['user' => $user, 'access_token' => $token]);
                            }
                            return $this->errorResponse('Please verify your account', 401);
                           }
                            return $this->errorResponse('Invalid credentials', 401);
    }

    public function verify(Request $request)
    {
        $validatedData = $request->validate([
            'mobile_number' => 'required|string|max:20',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('mobile_number', $validatedData['mobile_number'])
                    ->where('otp', $validatedData['otp'])
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }

        $user->is_verified = true;
        $user->otp = null;
        $user->save();

        return response()->json(['message' => 'Account verified successfully']);
    }








//     public function register($data)
//     {
        
//         // Logic to register a new user
//         return User::create([
//             'name' => $data['name'],
//             'mobile_number' => $data['mobile_number'],
//             'password' => Hash::make($data['password']),
//             'otp' => rand(100000, 999999),
//         ]);
//     }
//     public function login($data)
//     {
//         $user = User::where('mobile_number', $data['mobile_number'])->first();
//         if ($user && Hash::check($data['password'], $user->password)) {
//             return $user;
//         }
//         return null;
        
//     }

//     public function verify($data)
// {
//     $user = User::where('mobile_number', $data['mobile_number'])->first();
//     if ($user && $user->otp == $data['otp']) {
//         // Clear the OTP after successful verification
//         $user->otp = null;
//         $user->save();
//         return true;
//     }
//     return false;
//  }

//  public function SendOTP($mobileNumber, $password)
// {
//     $otp = rand(100000, 999999); 

//     $user = User::where('mobile_number', $mobileNumber)->where('password',$password)->first();
//     dd ($user);
//     if ($user) {
//         $user->otp = $otp;
//         $user->save();
//         return $otp;
//     }

//     return false; 
// }
}

