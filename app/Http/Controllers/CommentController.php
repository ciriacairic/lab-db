<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $parent_id    = $request->input('parent_id', null);
        $parent_type  = $request->input('parent_type', null);
        $user_id      = $request->input('user_id', null);
        $text         = $request->input('text', null);
        $thumbs_up    = $request->input('thumbs_up', null);
        $thumbs_down  = $request->input('thumbs_down', null);
        $reports      = $request->input('reports', null);

        try {
            $comment = Comment::create([
                'parent_id'    => $parent_id,
                'parent_type'  => $parent_type,
                'user_id'      => $user_id,
                'text'         => $text,
                'thumbs_up'    => $thumbs_up,
                'thumbs_down'  => $thumbs_down,
                'reports'      => $reports,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'comment_id' => $comment->id], 201);
    }

    public function show($parent_id, $parent_type)
    {
        $comments = Comment::where('parent_id', $parent_id)->where('parent_type', $parent_type)->get();

        return response()->json(['success' => true, 'comments' => $comments], 200);
    }

    public function destroy($comment_id)
    {
        $comment = Comment::find($comment_id);
        $comment->delete();
        return response()->json(['success' => true], 200);
    }
}
