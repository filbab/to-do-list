<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Knuckles\Scribe\Attributes\ResponseFromFile;

class AuthController extends Controller
{
   #[ResponseFromFile("docs/api_responses/register_200.json", 200)]
   #[ResponseFromFile("docs/api_responses/register_422.json", 422)]
   public function register(Request $request)
   {
      $validated = $request->validate([
         'name' => 'required|max:255',
         'email' => 'required|max:255|email|unique:users,email',
         'password' => 'required|confirmed|min:6'
      ]);

      $user = User::create($validated);

      return response()->json([
         'data' => $user,
         'access_token' => $user->createToken('api_token')->plainTextToken,
         'token_type' => 'Bearer'
      ], 201);
   }

   #[ResponseFromFile("docs/api_responses/login_200.json", 200)]
   #[ResponseFromFile("docs/api_responses/login_422.json", 422)]
   public function login(Request $request)
   {
      $validated = $request->validate([
         'email' => 'required|email',
         'password' => 'required'
      ]);

      if (! Auth::attempt($validated)) {
         return response()->json([
            'Invalid credentials',
         ], 401);
      }

      $user = User::where('email', $validated['email'])->first();

      return response()->json([
         'access_token' => $user->createToken('api_token')->plainTextToken,
         'token_type' => 'Bearer'
      ]);
   }
}