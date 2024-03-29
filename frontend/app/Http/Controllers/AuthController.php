<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();
        $role = $user->role;
        return $this->success(['user' => $user,
            'role' => $role,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function register(RegisterUserRequest $request)
    {
        $request->validated($request->all());
        $full_name = $request->fname . " " . $request->lname;
        $user = User::create([
            'name' => $full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customer = Customer::create([
            'user_id' => $user->id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'addressline' => $request->address,
            'phone' => '12344192111',
        ]);

        $pet = Pet::create([
            'pet_name' => $user->id,
            'age' => $request->age,
            'customer_id' => $customer->id,
        ]);

        Auth::login($user);

        return $this->success([
            'user' => $user,
            'role' => 'customer',
            'customer' => $customer,
            'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
        ]);
    }

    public function logout()
    {
        $user = User::find(Auth::id());
        $user->tokens()->delete();
        auth()->guard('web')->logout();
        return $this->success(['message' => "User successfully logged out.",
        ]);
    }
}
