<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::with(['category:id,name', 'instructor:id,name']);

        // Search by Title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by Level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Sorting — Default: rating desc
        $allowedSorts = ['rating', 'enrolled_count', 'duration', 'title'];
        $sortBy = in_array($request->sort_by, $allowedSorts) ? $request->sort_by : 'rating';
        $order  = in_array($request->order, ['asc', 'desc']) ? $request->order : 'desc';
        $query->orderBy($sortBy, $order);

        $courses = $query->get();

        // Dynamically add rating_class attribute
        $courses->transform(function ($course) {
            if ($course->rating >= 8.5) {
                $course->rating_class = 'Top Rated';
            } elseif ($course->rating >= 7.0) {
                $course->rating_class = 'Recommended';
            } else {
                $course->rating_class = 'Regular';
            }
            return $course;
        });

        return response()->json([
            'success' => true,
            'message' => 'Courses retrieved successfully',
            'data' => $courses
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $course = Course::with(['category:id,name', 'instructor:id,name'])->find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found',
            ], 404);
        }

        // Add rating_class attribute for single data detail
        if ($course->rating >= 8.5) {
            $course->rating_class = 'Top Rated';
        } elseif ($course->rating >= 7.0) {
            $course->rating_class = 'Recommended';
        } else {
            $course->rating_class = 'Regular';
        }

        return response()->json([
            'success' => true,
            'message' => 'Course retrieved successfully',
            'data' => $course,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->user()->role !== 'instructor'){
            return response()->json([
                'success' => false,
                'message' => 'Only instructors can create courses',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:course_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|numeric|min:0|max:10',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'required|integer|min:1',
            'thumbnail' => 'nullable|string',
            'status' => 'in:draft,published'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['instructor_id'] = $request->user()->id;

        $course = Course::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data'    => $course
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found',
            ], 404);
        }

        if($course->instructor_id !== $request->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this course',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'category_id'    => 'required|exists:course_categories,id',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'rating'         => 'required|numeric|min:0|max:10',
            'thumbnail'      => 'nullable|string',
            'level'          => 'required|in:beginner,intermediate,advanced',
            'duration'       => 'required|integer|min:1',
            'status'         => 'nullable|in:draft,published',
            'enrolled_count' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $course->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data'    => $course,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found',
            ], 404);
        }

        if($course->instructor_id !== $request->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this course',
            ], 403);
        }

        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully',
            'data' => null
        ], 200);
    }
}
