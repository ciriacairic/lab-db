<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($review_id)
    {
        $review = Review::find($review_id);

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        $review->username = User::find('user_id')->name;

        return response()->json($review);
    }

    public function store(Request $request)
    {
        $game_id = request()->input('game_id', null);
        $user_id = request()->input('user_id', null);
        $markdown_text = request()->input('markdown_text', null);
        $scores = request()->input('scores', null);

        try {
            $review = Review::create([
                'game_id' => "$game_id",
                'user_id' => $user_id,
                'markdown_text' => $markdown_text,
                'scores' => $scores,
            ]);
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
