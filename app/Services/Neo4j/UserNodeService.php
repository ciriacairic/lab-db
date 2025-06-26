<?php

namespace App\Services\Neo4j;

use Laudis\Neo4j\Contracts\ClientInterface;

class UserNodeService
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createUserNode(array $attributes): void
    {
        $cypher = <<<CYPHER
            MERGE (u:User {sql_user_id: \$id})
            SET u.name = \$name
            CYPHER;

        $this->client->run($cypher, [
            'id'   => $attributes['sql_user_id'],
            'name' => $attributes['name']
        ]);
    }

    public function likeGame(int $sqlUserId, int $sqlGameId): void
    {
        $cypher = <<<CYPHER
            MATCH (u:User {sql_user_id: \$userId})
            MATCH (g:Game {sql_game_id: \$gameId})
            MERGE (u)-[:LIKED]->(g)
            CYPHER;

        $this->client->run($cypher, [
            'userId' => $sqlUserId,
            'gameId' => $sqlGameId
        ]);
    }

    public function addFriend(int $sqlUserId, int $sqlFriendId): void
    {
        $cypher = <<<CYPHER
            MATCH (u:User {sql_user_id: \$userId})
            MATCH (f:User {sql_user_id: \$friendId})
            MERGE (u)-[:FRIENDS_WITH]->(f)
            MERGE (f)-[:FRIENDS_WITH]->(u)
            CYPHER;

        $this->client->run($cypher, [
            'userId'   => $sqlUserId,
            'friendId' => $sqlFriendId,
        ]);
    }
}