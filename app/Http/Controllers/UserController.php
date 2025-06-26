<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Mongo\Comment;
use App\Models\Mongo\Review;
use App\Models\Mongo\Theme;
use app\Models\User;
use App\Models\UserUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (!$user || $request->input('password') !=  $user->password) {
            return response()->json(['success' => false, 'user_id' => null], 401);
        }

        return response()->json(['success' => true, 'user_id' => $user->id]);
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $handle = $request->input('handle');
        $birth_date = $request->input('birth_date');

        try {
            $user = User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => $password,
                'handle'   => $handle,
                'birth_date' => $birth_date
            ]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'user_id' => null], 401);
        }

        return response()->json([
            'success' => true,
            'user_id' => $user->id
        ], 201);
    }

    public function followers($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $followers = $user->followers()->select('id', 'name', 'avatar')->get();

        return response()->json($followers);
    }

    public function following($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $followers = $user->following()->select('id', 'name', 'avatar')->get();

        return response()->json($followers);
    }

    public function show($user_id)
    {
        $user = User::find($user_id);
        $user->theme = Theme::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function ban($user_id)
    {
        $user = User::find($user_id);

        $user->status = 'banned';

        $user->save();

        return response()->json(['success' => true]);
    }

    public function destroy($user_id)
    {
        $user = User::find('user_id', $user_id);

        $user->delete();

        return response()->json(['success' => true]);
    }

    public function follow(Request $request)
    {
        $followerId = $request->input('follower_id');
        $followedId = $request->input('followed_id');

        $userUser = UserUser::where('follower_id', $followerId)->where('followed_id', $followedId)->first();

        if ($userUser) {
            $userUser->delete();
        } else {
            UserUser::create([
                'follower_id' => $followerId,
                'followed_id' => $followedId
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function update(Request $request, $user_id)
    {
        $data = $request->except('user_id');

        try {
            User::where('id', $user_id)->update($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true]);
    }

    public function get_libraries($user_id)
    {
        return Library::where('owner_id', $user_id)->get();
    }

    public function get_reviews($user_id)
    {
        return Review::where('user_id', $user_id)->get();
    }

    public function get_comments($user_id)
    {
        return Comment::where('user_id', $user_id)->get();
    }
}
