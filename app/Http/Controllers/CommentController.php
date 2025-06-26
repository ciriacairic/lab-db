<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $comment = Comment::create($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'review_id' => $comment->id], 201);
    }

    public function show($parent_id)
    {
        $comments = Comment::where('parent_id', $parent_id)->get();
        return response()->json(['success' => true, 'comments' => $comments], 200);
    }

    public function destroy($comment_id)
    {
        $comment = Comment::first($comment_id);
        $comment->delete();
        return response()->json(['success' => true], 200);
    }
}
