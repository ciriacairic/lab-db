<?php

namespace App\Services\Neo4j;

use Laudis\Neo4j\Contracts\ClientInterface;

class FranchiseNodeService
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createFranchise(array $attributes): void
    {
        $cypher = <<<CYPHER
          MERGE (f:Franchise {sql_franchise_id: \$id})
          SET f.name = \$name
          CYPHER;

        $this->client->run($cypher, [
            'id'   => $attributes['sql_franchise_id'],
            'name' => $attributes['name'],
        ]);
    }

    public function attachToGame(int $sqlGameId, int $sqlFranchiseId): void
    {
        $cypher = <<<CYPHER
        MATCH (g:Game {sql_game_id: \$gameId})
        MATCH (f:Franchise {sql_franchise_id: \$franchiseId})
        MERGE (g)-[:PART_OF]->(f)
        CYPHER;

        $this->client->run($cypher, [
            'gameId'       => $sqlGameId,
            'franchiseId'  => $sqlFranchiseId,
        ]);
    }
}