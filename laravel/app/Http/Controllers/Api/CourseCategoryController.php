<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Validator;


class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CourseCategory::all();
        return response()->json([
            'success' => true,
            'message' => 'Course categories retrieved successfully',
            'data' => $categories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 422);
        }

        $category = CourseCategory::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Course category created successfully',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = CourseCategory::with('courses')->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Course category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Course category retrieved successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = CourseCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Course category not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:course_categories,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 422);
        }

        $category->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Course category updated successfully',
            'data' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CourseCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Course category not found'
            ], 404);
        }

        if ($category->courses()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with associated courses'
            ], 400);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course category deleted successfully'
        ], 200);
    }
}
