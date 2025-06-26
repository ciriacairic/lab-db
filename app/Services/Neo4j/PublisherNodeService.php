<?php

namespace App\Services\Neo4j;

use Laudis\Neo4j\Contracts\ClientInterface;

class PublisherNodeService
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createPublisher(array $attributes): void
    {
        $cypher = <<<CYPHER
          MERGE (p:Publisher {sql_publisher_id: \$id})
          SET p.name = \$name
          CYPHER;

        $this->client->run($cypher, [
            'id'   => $attributes['sql_publisher_id'],
            'name' => $attributes['name'],
        ]);
    }

    public function attachToGame(int $sqlGameId, int $sqlPublisherId): void
    {
        $cypher = <<<CYPHER
          MATCH (g:Game {sql_game_id: \$gameId})
          MATCH (p:Publisher {sql_publisher_id: \$publisherId})
          MERGE (g)-[:PUBLISHED_BY]->(p)
          CYPHER;

        $this->client->run($cypher, [
            'gameId'       => $sqlGameId,
            'publisherId'  => $sqlPublisherId,
        ]);
    }
}