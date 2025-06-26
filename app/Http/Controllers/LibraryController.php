<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Library;
use App\Models\LibraryGame;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function store(Request $request){
        $name = $request->input('name');
        $owner_id = $request->input('owner_id');
        $description = $request->input('description', null);

        try {
            $library = Library::create([
                'name' => $name,
                'owner_id' => $owner_id,
                'description' => $description
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json($library->id, 201);
    }

    public function destroy($library_id){
        $library = Library::find($library_id);

        $library->delete();

        return response()->json(['success' => true]);
    }

    public function add_game($library_id, $game_id){
        try {
            LibraryGame::create([
                'library_id' => $library_id,
                'game_id' => $game_id
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true]);
    }

    public function remove_game($library_id, $game_id){
        $libraryGame = LibraryGame::where('library_id', $library_id)->where('game_id', $game_id);

        $libraryGame->delete();

        return response()->json(['success' => true]);
    }

    public function get_games($library_id)
    {
        $gameIds = Library::where('library_id', $library_id)->pluck('game_id')->toArray();
        $games = Game::whereIn('id', $gameIds)->get();

        return response()->json($games);
    }
}
