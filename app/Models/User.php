<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Library;
use App\Models\Mongo\Theme;
use App\Models\UserUser;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = bcrypt($user->password);

            Library::create([
                'owner_id' => $user->id,
                'name' => 'Favoritos',
                'description' => 'Biblioteca de favoritos',
            ]);

            Library::create([
                'owner_id' => $user->id,
                'name' => 'Jogados',
                'description' => 'Biblioteca de jogos jogados',
            ]);

            Theme::create([
                'user_id' => $user->id,
                'name' => 'Padrão',
            ]);
        });
    }

    public function libraries()
    {
        return $this->hasMany(Library::class, 'owner_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id');
    }

    public function getGamesFromFollowedUsers()
    {
        $followingIds = UserUser::where('follower_id', $this->id)->pluck('followed_id');

        $gameFrequency = [];

        foreach ($followingIds as $followedId) {
            $favoriteLibraries = Library::where('owner_id', $followedId)
                ->where('name', 'Favoritos')
                ->pluck('id');

            $gameIds = LibraryGame::whereIn('library_id', $favoriteLibraries)->pluck('game_id');

            foreach ($gameIds as $gameId) {
                if (isset($gameFrequency[$gameId])) {
                    $gameFrequency[$gameId]++;
                } else {
                    $gameFrequency[$gameId] = 1;
                }
            }
        }

        $topGameIds = collect($gameFrequency)
            ->sortDesc()
            ->take(20)
            ->keys();

        $games = Game::whereIn('id', $topGameIds)->get()->keyBy('id');

        return $topGameIds->map(fn($id) => $games[$id])->filter()->values();
    }
}
