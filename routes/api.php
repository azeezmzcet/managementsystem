<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login']);



Route::get('/studentlist', [StudentController::class, 'studentList']);
// Define the resource routes for the StudentController
Route::apiResource('/students', StudentController::class);



Route::post('/teacher-login',[AuthController::class, 'teacherLogin']);
Route::post('/teacher-register',[AuthController::class, 'createTeacher']);

//
Route::get('/teacher', [AuthController::class, 'getTeachers']);
//


Route::apiResource('/courses', CourseController::class);





//Route::middleware('auth:sanctum')->get('/studentlist', [AuthController::class, 'getStudentsByCourse']);
Route::post('/courses/{course}/assign', [CourseController::class, 'assignTeacherToCourse']); // Example: Assign teacher to a course
