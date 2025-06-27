<?php

namespace App\Http\Controllers;

use App\Models\Mongo\GameRequest;
use Illuminate\Http\Request;

class GameRequestController extends Controller
{
    public function store(Request $request)
    {
        $user_id         = $request->input('user_id', null);
        $game_title      = $request->input('game_title', null);
        $justification   = $request->input('justification', null);
        $status          = $request->input('status', null);
        $moderator_notes = $request->input('moderator_notes', null);

        try {
            $gameRequest = GameRequest::create([
                'user_id'         => $user_id,
                'game_title'      => $game_title,
                'justification'   => $justification,
                'status'          => $status,
                'moderator_notes' => $moderator_notes,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'game_request_id' => $gameRequest->id], 201);
    }

    public function handle(Request $request, $game_request_id)
    {
        $decision = $request->input('decision');

        $gameRequest = GameRequest::find($game_request_id);

        if ($gameRequest->status != 'pending'){
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $gameRequest->status = $decision;
        $gameRequest->save();

        return response()->json(['success' => true, 'decision' => $decision], 200);
    }

    public function destroy($game_request_id)
    {
        $gameRequest = GameRequest::find($game_request_id);
        $gameRequest->delete();
        return response()->json(['success' => true], 200);
    }

    public function index()
    {
        $gameRequests = GameRequest::where('status', 'pending')->get();
        return response()->json($gameRequests, 200);
    }
}
