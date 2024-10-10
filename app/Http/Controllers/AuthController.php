<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;





class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',  // Fixed typo from 'reqired' to 'required'
            'password' => 'required|string|min:6',
            // 'role' => 'required|in:principal,teacher',
            'course' => 'nullable|string',  // Only for teachers
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['message' => 'Please check the registration inputs.'], 400);
        }
    
       
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
    
       
        $user = User::create($data);
    
        
        $tokenResult = $user->createToken('authToken');  // Adjusted token name
        $res = $tokenResult->plainTextToken;
    
        // Return response with token and other info
        return response()->json([
            'tokenName' => $res,  // Token returned in response
            'tokentype' => 'Bearer',  // Corrected token type format
            'message' => 'User registered successfully.'
        ], 201);
    }
    
///////////////

 public function login(Request $request)
     {
    $credentials = $request->only('username', 'password');

    
    logger('Attempting to log in with:', $credentials);

    $user = User::where('username', $credentials['username'])->first();

    
    // if ($user) {
    //     logger('User found:', $user->toArray());
    // } else {
    //     logger('User not found with username:', $credentials['username']);
    // }
    if (!$user) {
        logger('User not found with username:', $credentials['username']);
        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    // if ($user->role !== 'principal') {
    //     return response()->json(['message' => 'Access denied. Only principals can log in.'], 403);
    // }
    
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials.'], 401);
    }


    if($user->role === "principal"){
        $tokenResult=$user->createToken('authToken');
        $token =$tokenResult->plainTextToken;

        return response()->json([
            'tokenName'=>$token,
            'tokenType'=>'Bearer',
            'role' => 'principal',
            'message'=>'princopal login successful'
        ],200);

    }elseif($user->role === "teacher"){
        $tokenResult=$user->createToken('authToken');
        $token =$tokenResult->plainTextToken;


        return response()->json([
            'tokenName'=>$token,
            'tokenType'=>'Bearer',
            'role' => 'teacher',
            'message'=>'teacher login successful'
        ],200);
    }

    return response()->json(['message' => 'Unauthorized.'], 403);

   
    // $tokenResult = $user->createToken('authToken');
    // $token = $tokenResult->plainTextToken;

    // return response()->json([
    //     // 'message' => ucfirst($user->role) . ' login successful.',
    //     'tokenName' => $token,
    //     'tokentype' => 'Bearer',
    //     // 'user' => $user,
    // ], 200);
     }


// public function login(Request $request)
// {
//     $credentials = $request->only('username', 'password');

//     if (!Auth::attempt($credentials)) {
//         return response()->json(['message' => 'Invalid credentials'], 401);
//     }

//     $user = Auth::user();
//     $tokenResult = $user->createToken('authToken');
//     $token = $tokenResult->plainTextToken;

//     return response()->json([
//         'tokenName' => $token,
//         'role' => $user->role, // Include user role in the response
//         'message' => 'Login successful',
//     ]);
// }




////////////////////


public function teacherLogin(Request $request) 
{
    $credentials = $request->only('username', 'password');

    // Log the attempt
    logger('Attempting to log in with:', $credentials);

    // Check for user
    $user = User::where('username', $credentials['username'])->first();

    // If user doesn't exist or password is incorrect
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials.'], 401);
    }

    // Check if user is a principal
    if ($user->role !== 'principal') {
        return response()->json(['message' => 'Only principals can log in to the dashboard.'], 403);
    }

    // Create token for authentication
    $tokenResult = $user->createToken('authToken');
    $token = $tokenResult->plainTextToken;

    return response()->json([
        'tokenName' => $token,
        'tokentype' => 'Bearer',
    ], 200);
}

// Create teacher
public function createTeacher(Request $request)
{
    // Validation rules
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|unique:users',
        'password' => 'required|string|min:6',
        'course' => 'nullable|string',  // Only for teachers
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['message' => 'Please check the registration inputs.'], 400);
    }

    // Create user data
    $data = $request->only('username', 'course'); // Include course if needed
    $data['password'] = Hash::make($request->password); // Hash password

    // Create the teacher
    $teacher = User::create($data);

    return response()->json([
        'message' => 'Teacher created successfully.',
        'teacher' => $teacher,
    ], 201);


     }




}
