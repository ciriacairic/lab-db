<?php

namespace App\Console\Commands;

use App\Models\Library;
use App\Models\LibraryGame;
use App\Models\Mongo\Comment;
use App\Models\Mongo\GameRequest;
use App\Models\Mongo\Report;
use App\Models\Mongo\Review;
use app\Models\User;
use App\Models\UserUser;
use Illuminate\Console\Command;

class SeedPostgresMongoDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed-ps-mongo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Popula os bancos Postgres e MongoDB';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Criação de 2 users
        $u1 = User::updateOrCreate([
            'handle' => 'u1',],[
            'name' => 'u1',
            'email' => 'email@gmail.com',
            'password' => 'senha',
            'nationality' => 'Brasil',
            'gender' => 'male',
            'verified' => 'false',
            'birth_date' => '02/01/2004',
            'role' => 'admin',
        ]);

        $u2 = User::updateOrCreate([
            'handle' => 'u2',],[
            'name' => 'u2',
            'email' => 'gmail@gmail.com',
            'password' => 'senha',
            'nationality' => 'Brasil',
            'gender' => 'male',
            'verified' => 'false',
            'birth_date' => '29/02/1950',
            'role' => 'admin',
        ]);

        UserUser::updateOrCreate([
            'follower_id' => $u1->id,
            'followed_id' => $u2->id,
        ],[]);

        UserUser::updateOrCreate([
            'follower_id' => $u2->id,
            'followed_id' => $u1->id,
        ],[]);

        $library = Library::updateOrCreate([
            'owner_id' => $u1->id,
            'name' => 'Recentes',
            'description' => 'Jogos que eu joguei em 2025'
        ],[]);

        LibraryGame::updateOrCreate([
            'library_id' => $library->id,
            'game_id' => 33,
        ],[]);

        LibraryGame::updateOrCreate([
            'library_id' => $library->id,
            'game_id' => 17,
        ],[]);

        LibraryGame::updateOrCreate([
            'library_id' => $library->id,
            'game_id' => 92,
        ],[]);

        $review = Review::updateOrCreate([
            'user_id' => $u2->id,
            'game_id' => '14',
            'comments' => 'Nunca pensei que passaria tanto tempo em um jogo de fazendinha',
            'scores' => [
                'graphics' => 10,
                'gameplay' => '10',
                'nostalgic' => '10',
            ]
        ]);

        Comment::updateOrCreate([
            'user_id' => $u1->id,
            'parent_id' => $review->_id,
            'parent_type' => 'review',
            'text' => 'Vc nem ve o tempo passar enquanto pesca',
            'thumbs_up' => 'thumbs_up',
        ]);

        GameRequest::updateOrCreate([
            'user_id' => $u1->id,
            'game_name' => 'Sekiro: Shadows Die Twice',
            'game_description' => 'O jogador assume o papel de um shinobi com uma prótese no lugar do braço, que se vê obrigado a se vingar de um clã samurai que raptou seu mestre e o deixou por morto',
        ]);

        Report::updateOrCreate([
            'reporter_id' => $u1->id,
            'reported_item_id' => $review->_id,
            'reported_item_type' => 'review',
            'status' => 'pending',
        ]);
    }
}
