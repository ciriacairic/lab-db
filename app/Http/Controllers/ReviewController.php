<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($review_id)
    {
        $review = Review::find($review_id);

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        return response()->json($review);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $review = Review::create($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'review_id' => $review->id], 201);
    }

    public function destroy($review_id)
    {
        $review = Review::find($review_id);

        $review->delete();

        return response()->json(['success' => true]);
    }
}
