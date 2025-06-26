<?php

namespace App\Services\Neo4j;

use Laudis\Neo4j\Contracts\ClientInterface;

class TagNodeService
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createTag(array $attributes): void
    {
        $cypher = <<<CYPHER
          MERGE (t:Tag {sql_tag_id: \$id})
          SET t.name = \$name
          CYPHER;

        $this->client->run($cypher, [
            'id'   => $attributes['sql_tag_id'],
            'name' => $attributes['name'],
        ]);
    }

    public function attachToGame(int $sqlGameId, int $sqlTagId): void
    {
        $cypher = <<<CYPHER
          MATCH (g:Game {sql_game_id: \$gameId})
          MATCH (t:Tag {sql_tag_id: \$tagId})
          MERGE (g)-[:HAS_TAG]->(t)
          CYPHER;

        $this->client->run($cypher, [
            'gameId' => $sqlGameId,
            'tagId'  => $sqlTagId,
        ]);
    }
}