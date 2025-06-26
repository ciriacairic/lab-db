<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use App\Models\Neo4j\NodeDeveloper;
use App\Models\Neo4j\NodeFranchise;
use App\Models\Neo4j\NodeGame;
use App\Models\Neo4j\NodePublisher;
use App\Models\Neo4j\NodeTag;
use App\Models\Neo4j\NodeUser;

class GenerateCypherDump extends Command
{
    protected $signature = 'graph:dump-cypher';
    protected $description = 'Dump Cypher queries from Neo4j models to neo4j_export.cypher';

    public function handle()
    {
        $output = [];

        /** DUMP USERS **/
        $users = NodeUser::all();
        foreach ($users as $user) {
            $safeName = $this->escape($user->name);
            $output[] = "MERGE (u:User {sql_id: '{$user->sql_id}', name: '{$safeName}'})";
        }

        /** DUMP GAMES **/
        $games = NodeGame::with(['developer', 'publisher', 'franchise', 'tags'])->get();

        foreach ($games as $game) {
            $safeGameName = $this->escape($game->name);
            $output[] = "MERGE (g:Game {sql_id: {$game->sql_id}, name: '{$safeGameName}'})";

            if ($dev = $game->developer) {
                $safeDevName = $this->escape($dev->name);
                $output[] = "MERGE (d:Developer {sql_id: {$dev->sql_id}, name: '{$safeDevName}'})";
                $output[] = "MERGE (g)-[:DEVELOPED_BY]->(d)";
            }

            if ($pub = $game->publisher) {
                $safePubName = $this->escape($pub->name);
                $output[] = "MERGE (p:Publisher {sql_id: {$pub->sql_id}, name: '{$safePubName}'})";
                $output[] = "MERGE (g)-[:PUBLISHED_BY]->(p)";
            }

            if ($franchise = $game->franchise) {
                $safeFranchiseName = $this->escape($franchise->name);
                $output[] = "MERGE (f:Franchise {sql_id: {$franchise->sql_id}, name: '{$safeFranchiseName}'})";
                $output[] = "MERGE (g)-[:PART_OF]->(f)";
            }

            foreach ($game->tags as $tag) {
                $safeTagName = $this->escape($tag->name);
                $output[] = "MERGE (t:Tag {sql_id: {$tag->sql_id}, name: '{$safeTagName}'})";
                $output[] = "MERGE (g)-[:HAS_TAG]->(t)";
            }
        }

        /** WRITE & DISPLAY DUMP **/
        $cypher = implode(";\n", $output) . ';';

        file_put_contents(base_path('neo4j_export.cypher'), $cypher);

        $this->info("✅ Cypher file exported to neo4j_export.cypher");
    }

    /**
     * Escape single quotes and backslashes to avoid syntax errors in Cypher
     */
    protected function escape(string $string): string
    {
        return addcslashes($string, "'\\");
    }
}