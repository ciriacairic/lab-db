<?php

namespace app\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Library;
use App\Models\Mongo\Theme;

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
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function getGamesFromFollowedUsers()
    {
        $followingIds = UserUser::where('follower_id', $this->id)->pluck('followed_id')->toArray();
        $following = User::whereIn('id', $followingIds)->get();

        $games = collect([]);
        foreach ($following as $f) {
            $favoritesLibrary = Library::where('owner_id', $f->id)->where('name', 'Favoritos')->get();

            $games = $games->merge(Game::whereIn('id', LibraryGame::where('library_id', $favoritesLibrary->id)->pluck('game_id')->toArray())->get());
        }

        return $games;
    }
}
