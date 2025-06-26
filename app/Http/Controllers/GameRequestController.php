<?php

namespace App\Http\Controllers;

use App\Models\Mongo\GameRequest;
use Illuminate\Http\Request;

class GameRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $gameRequest = GameRequest::create($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'review_id' => $gameRequest->id], 201);
    }

    public function destroy($game_request_id)
    {
        $gameRequest = GameRequest::find($game_request_id);
        $gameRequest->delete();
        return response()->json(['success' => true], 200);
    }

    public function index()
    {
        $gameRequests = GameRequest::all();
        return response()->json($gameRequests, 200);
    }
}
