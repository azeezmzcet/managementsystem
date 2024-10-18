<?php
namespace App\Http\Controllers;

use App\Models\Studentlists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Fetch all students.
     */ 
    public function index()
    {
        $students = Studentlists::all();
        return response()->json($students, 200);
    }

    /**
     * Store a new student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
        ]);

        $student = Studentlists::create($request->all());

        return response()->json($student, 201);
    }

    /**
     * Display a specific student.
     */
    public function show($id)
    {
        $student = Studentlists::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student, 200);
    }

    /**
     * Update a specific student.
     */
    public function update(Request $request, $id)
    {
        $student = Studentlists::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'course' => 'sometimes|required|string|max:255',
        ]);

        $student->update($request->all());

        return response()->json($student, 200);
    }

    /**
     * Remove a specific student.
     */
    public function destroy($id)
    {
        $student = Studentlists::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted successfully'], 200);
    }

    /**
     * Fetch students by the course.
     */
    public function studentList(Request $request)
    {
        // Retrieve the 'course' from the request query parameters
        $course = $request->query('course');

        // Validate if the course parameter is provided
        if (!$course) {
            return response()->json(['message' => 'Course parameter is missing'], 400);
        }

        // Fetch students based on the course
        $students = Studentlists::where('course', $course)->get();

        // Check if any students are found for the given course
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found for the selected course'], 404);
        }

        // Return the list of students for the course
        return response()->json($students, 200);
    }





    
    public function getStudentsByCourse(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
    
        // Ensure that only teachers can access this function
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'Access denied. Only teachers can view student lists.'], 403);
        }
       // $user = $request->query('course');
        // Fetch students based on the teacher's assigned course
        $students = Studentlists::where('course', $user->course)->get();
    
        // If no students found, return a message
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found for your course.'], 404);
        }
    
        return response()->json($students, 200);
    }








//     // Inside StudentController.php
// public function getStudentsByCourse(Request $request)
// {
//     $user = Auth::user();
    
//     if ($user->role !== 'teacher') {
//         return response()->json(['message' => 'Access denied. Only teachers can view student lists.'], 403);
//     }

//     $students = Studentlists::where('course', $user->course)->get();

//     if ($students->isEmpty()) {
//         return response()->json(['message' => 'No students found for your course.'], 404);
//     }

//     return response()->json($students, 200);
// }


    
}
