<?php



namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // List all courses
    public function index()
    {
        return Course::all();
    }

    // Show a single course
    public function show($id)
    {
        return Course::find($id);
    }

    // Store a new course
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $course = Course::create([
            'name' => $request->name,
        ]);

        return response()->json($course, 201);
    }

    // Update an existing course
    public function update(Request $request, $id) {
        $course = Course::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $course->update([
            'name' => $request->name,
        ]);

        return response()->json($course);
    }
    // Delete a course
    public function destroy($id) {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully']);
    }

    // Assign teacher to course
    public function assignTeacherToCourse(Request $request, $courseId)
    {
        $course = Course::find($courseId);
        $course->teacher_id = $request->teacher_id;
        $course->save();

        return response()->json([
            'message' => 'Teacher assigned to course successfully.',
            'course' => $course,
        ]);
    }
}
