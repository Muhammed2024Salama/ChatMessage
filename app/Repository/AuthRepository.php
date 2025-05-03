<?php

namespace App\Repository;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interface\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helper\ResponseHelper;
use Exception;
class AuthRepository implements AuthInterface
{
    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'email_verified_at' => now()
            ]);

            if ($user) {
                return ResponseHelper::success('User has been Registered Successfully!', $user, 201);
            }

            return ResponseHelper::error('Unable to register user. Please try again!', 400);

        } catch (Exception $e) {
            \Log::error("Register Error: {$e->getMessage()} - Line {$e->getLine()}");

            return ResponseHelper::error('Unable to register user. ' . $e->getMessage(), 500);
        }
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ResponseHelper::error('Invalid credentials', 400);
            }

            $user = Auth::user();
            $token = $user->createToken('MyApiToken')->plainTextToken;

            return ResponseHelper::success('Logged in successfully', [
                'user' => $user,
                'token' => $token
            ], 200);

        } catch (Exception $e) {
            \Log::error("Login Error: {$e->getMessage()} - Line {$e->getLine()}");

            return ResponseHelper::error('Login failed. ' . $e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        try {
            $user = Auth::user();

            if ($user) {
                return ResponseHelper::success('User profile fetched successfully', $user, 200);
            }

            return ResponseHelper::error('Invalid token. Unable to fetch profile.', 400);

        } catch (Exception $e) {
            \Log::error("Profile Error: {$e->getMessage()} - Line {$e->getLine()}");

            return ResponseHelper::error('Failed to fetch profile. ' . $e->getMessage(), 500);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userLogout()
    {
        try {
            $user = Auth::user();

            if ($user) {
                $user->currentAccessToken()->delete();

                return ResponseHelper::success('Logged out successfully', null, 200);
            }

            return ResponseHelper::error('Invalid token. Unable to logout.', 400);

        } catch (Exception $e) {
            \Log::error("Logout Error: {$e->getMessage()} - Line {$e->getLine()}");

            return ResponseHelper::error('Logout failed. ' . $e->getMessage(), 500);
        }
    }
}
