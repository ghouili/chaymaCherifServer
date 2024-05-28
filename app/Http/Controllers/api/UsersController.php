<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Mail\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'message' => 'all users',
            'data' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User found successfully',
                'data' => $user,
            ]);
        }
            return response()->json([
                'success' => true,
                'message' => 'User doesnt Exist',
                // 'data' => $user,
            ]);


    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
            'data' => null,
        ]);
    }


    /**
     * sign up a newly created resource in storage.
     */

    public function SignUp(UserRequest $request)
    {
        try {

            $validatedData = $request->validated();

            $validatedData['password'] = Hash::make($validatedData['password']);

            if ($request->hasFile('avatar')) {
                $imageName = Str::random(32) . "." . $request->avatar->getClientOriginalExtension();
                $validatedData['avatar'] = $imageName;
                $request->avatar->move(public_path() . '/images/', $imageName);
            } else {
                $validatedData['avatar'] = "avatar.png";
            }

            $user = User::create($validatedData);
            $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'userId' => $user,
                'token' => $token,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'User creation failed: ' . $th->getMessage(),
            ], 500);
        }
    }
    /**
     * sign in with an existing resource.
     */

    public function SignIn(Request $request)
    {
        try {
            // Validate user data using LoginRequest rules
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Attempt login using Laravel's Auth facade
            // return dd($credentials);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid login credentials',
                ], 401);
            }

            // User successfully logged in, retrieve the user model
            $user = Auth::user();

            // Create a token (customize token name as needed)
            $token = $user->createToken('MyAppToken')->plainTextToken; // Avoid exposing plain text tokens in production

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'userId' => $user,
                'token' => $token,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Signin failed: ' . $th->getMessage(), // Consider more informative error messages
            ], 500);
        }
    }

    /**
     * logout from a connected user.
     */

    public function LogOut(Request $request)
    {
        // dd('here');
        try {
            // Access the user using the guard (optional)
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            // $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            // Revoke the current access token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'User Logged Out Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function AddUser(UserRequest $request)
    {

        try {
            $validatedData = $request->validated();

            $password = Str::random(8);


            if ($request->hasFile('avatar')) {
                $imageName = Str::random(32) . "." . $request->avatar->getClientOriginalExtension();
                $validatedData['avatar'] = $imageName;
                $request->avatar->move(public_path() . '/images/', $imageName);
            }

            $user = new User();


            $user->firstName = $validatedData['firstName'];
            $user->lastName = $validatedData['lastName'];
            $user->email = $validatedData['email'];
            $user->role = $validatedData['role'];
            $user->cin = $validatedData['cin'];
            $user->password =  Hash::make($password);
            $user->avatar = $validatedData['avatar'] ?? 'avatar.png';
            $user->save();

            $data = [
                "firstName" => $validatedData['firstName'],
                "lastName" => $validatedData['lastName'],
                "email" => $validatedData['email'],
                "role" => $validatedData['role'],
                "password" => $password,
            ];

            Mail::to($validatedData['email'])->send(new Contact($data));

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'User creation failed: ' . $th->getMessage(),
            ], 500);
        }
    }


    public function getUserCount()
    {
        $userCount = DB::table('users')
            ->select(DB::raw('role, count(*) as user_count'))
            ->groupBy('role')
            ->get()
            ->pluck('user_count', 'role');

        return response()->json([
            'success' => true,
            'data' => $userCount->toArray(),
        ]);
    }


    public function getUserCountByRole()
    {

        $roles = ['etudiant', 'enseignant', 'chef de laboratoire'];

        $data = DB::table('users')
            ->select(DB::raw('role, count(*) as user_count'))
            ->whereIn('role', $roles)
            ->groupBy('role')
            ->get();

        $totalCount = $data->sum('user_count');

        $percentages = $data->map(function ($item) use ($totalCount) {
            $percentage = ($item->user_count / $totalCount) * 100;
            return [
                'role' => $item->role,
                'percentage' => number_format($percentage, 2), // Use number_format for better formatting
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $percentages,
        ]);
    }
    
}
