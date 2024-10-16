<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Studentlists;
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
            'role' => 'required|in:principal,teacher',
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
            'course' => $user->course,
            'message'=>'teacher login successful'
        ],200);
    }

    return response()->json(['message' => 'Unauthorized.'], 403);

   
    $tokenResult = $user->createToken('authToken');
    $token = $tokenResult->plainTextToken;

    return response()->json([
        // 'message' => ucfirst($user->role) . ' login successful.',
        'tokenName' => $token,
        'tokentype' => 'Bearer',
        // 'user' => $user,
    ], 200);
    }

  //old login
    /////////////////
    //newlogin
//     public function login(Request $request)
// {
//     $credentials = $request->only('username', 'password');

//     // Attempt to find the user
//     $user = User::where('username', $credentials['username'])->first();

//     // Check if user exists and password is valid
//     if (!$user || !Hash::check($credentials['password'], $user->password)) {
//         return response()->json(['message' => 'Invalid credentials.'], 401);
//     }

//     // Generate authentication token
//     $tokenResult = $user->createToken('authToken');
//     $token = $tokenResult->plainTextToken;

//     if ($user->role === 'teacher') {
//         return response()->json([
//             'tokenName' => $token,
//             'tokenType' => 'Bearer',
//             'role' => 'teacher',
//             'course' => $user->course, // Return the teacher's course in the response
//             'message' => 'Teacher login successful.',
//         ], 200);
//     }

//     return response()->json(['message' => 'Unauthorized.'], 403);
// }



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
        'course' => 'required|string',  // Only for teachers
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['message' => 'Please check the registration inputs.'], 400);
    }

    // Create user data
    $data = $request->only('username','password','course');            // Include course if needed
    $data['role'] = 'teacher';
    $data['password'] = Hash::make($request->password); // Hash password

    // Create the teacher
    $teacher = User::create($data);

    // $tokenResult = $teacher->createToken('authToken');  // Adjusted token name
    //     $res = $tokenResult->plainTextToken;
    

    return response()->json([
        'message' => 'Teacher created successfully.',
        'teacher' => $teacher,
    ], 201);


     }






    //  public function getStudentsByCourse(Request $request)
    // {
    //     // Get the authenticated user
    //     $user = Auth::user();
    
    //     // Ensure that only teachers can access this function
    //     if ($user->role !== 'teacher') {
    //         return response()->json(['message' => 'Access denied. Only teachers can view student lists.'], 403);
    //     }
    
    //     // Fetch students based on the teacher's assigned course
    //     $students = Studentlists::where('course', $user->course)->get();
    
    //     // If no students found, return a message
    //     if ($students->isEmpty()) {
    //         return response()->json(['message' => 'No students found for your course.'], 404);
    //     }
    
    //     return response()->json($students, 200);
    // }




    public function getTeachers()
    {
        $teachers = User::where('role', 'teacher')->get();
    
        return response()->json([
            'teachers' => $teachers
        ], 200);
    }
    








}
