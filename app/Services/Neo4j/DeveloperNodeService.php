<?php

namespace App\Services\Neo4j;

use Laudis\Neo4j\Contracts\ClientInterface;

class DeveloperNodeService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createDeveloper(array $attributes): void
    {
        $cypher = <<<CYPHER
            MERGE (d:Developer {sql_developer_id: \$id})
            SET d.name = \$name
        CYPHER;

        $this->client->run($cypher, [
            'id'   => $attributes['sql_developer_id'],
            'name' => $attributes['name']
        ]);
    }

    public function attachToGame(int $sqlDeveloperId, int $sqlGameId): void
    {
        $cypher = <<<CYPHER
            MATCH (d:Developer {sql_developer_id: \$devId})
            MATCH (g:Game {sql_game_id: \$gameId})
            MERGE (g)-[:DEVELOPED_BY]->(d)
        CYPHER;

        $this->client->run($cypher, [
            'devId'  => $sqlDeveloperId,
            'gameId' => $sqlGameId
        ]);
    }
}