<?php

namespace App\Http\Controllers;

use App\Models\Studentlists;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentsdata = Studentlists::all();
        return response()->json($studentsdata, 200);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // // public function create($id)
    // // {
    // //     // if(!$studentsdata){
    // //     //     return res()->json(['message'=>'student not found'],404);
    // //     // }
    // // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $validatedData =$request->validate([
    //         'name' => 'required|string|max:255',
    //         'course' => 'required|string|in:BBA,B.Sc,B.Com,B.Tech',
    //     ]);
    //     $student = Studentlists::create($validatedData);

    //     return response()->json($student, 201);
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     $student = Studentlists::find($id);

    //     if (!$student) {
    //         return response()->json(['message' => 'Student not found'], 404);
    //     }
    //     return response()->json($student, 200);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // // public function edit(string $id)
    // // {
    // //     //
    // // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     $student = Studentlists::find($id);

    //     if (!$student) {
    //         return response()->json(['message' => 'Student not found'], 404);
    //     }

    //     $validatedData = $request->validate([
    //         'name' => 'sometimes|required|string|max:255',
    //         'course' => 'sometimes|required|string|in:BBA,B.Sc,B.Com,B.Tech',
    //     ]);

    //     $student->update($validatedData);

    //     return response()->json($student, 200);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     $student = Studentlists::find($id);

    //     if (!$student) {
    //         return response()->json(['message' => 'Student not found'], 404);
    //     }

    //     $student->delete();

    //     return response()->json(['message' => 'Student deleted successfully'], 204);
    
    // }




    public function studentList(Request $request)
    {
        
        $name = $request->input('name');
        $course = $request->input('course');

        
        $students = Studentlists::where('name', $name)
                                ->where('course', $course)
                                ->get();

        
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found for the given criteria'], 404);
        }

        return response()->json($students, 200);
    }



}
