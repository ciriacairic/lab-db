<?php

namespace App\Services\Neo4j;

use Laudis\Neo4j\Contracts\ClientInterface;

class GameNodeService
{
    protected ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function createNode(array $attributes): void
    {
        $this->client->run(<<<'CYPHER'
            MERGE (g:Game {sql_game_id: $sql_game_id})
            SET g.name = $name
            CYPHER, [
            'sql_game_id' => $attributes['sql_game_id'],
            'name'        => $attributes['name'],
        ]);
    }

    public function linkDeveloper(int $sqlGameId, int $sqlDeveloperId, string $developerName): void
    {
        $this->client->run(<<<'CYPHER'
            MERGE (g:Game {sql_game_id: $game_id})
            MERGE (d:Developer {sql_developer_id: $dev_id})
            SET d.name = $dev_name
            MERGE (g)-[:DEVELOPED_BY]->(d)
            CYPHER, [
            'game_id'  => $sqlGameId,
            'dev_id'   => $sqlDeveloperId,
            'dev_name' => $developerName,
        ]);
    }

    public function linkPublisher(int $sqlGameId, int $sqlPublisherId, string $publisherName): void
    {
        $this->client->run(<<<'CYPHER'
            MERGE (g:Game {sql_game_id: $game_id})
            MERGE (p:Publisher {sql_publisher_id: $pub_id})
            SET p.name = $pub_name
            MERGE (g)-[:PUBLISHED_BY]->(p)
            CYPHER, [
            'game_id'  => $sqlGameId,
            'pub_id'   => $sqlPublisherId,
            'pub_name' => $publisherName,
        ]);
    }

    public function linkFranchise(int $sqlGameId, int $sqlFranchiseId, string $franchiseName): void
    {
        $this->client->run(<<<'CYPHER'
            MERGE (g:Game {sql_game_id: $game_id})
            MERGE (f:Franchise {sql_franchise_id: $franchise_id})
            SET f.name = $franchise_name
            MERGE (g)-[:PART_OF]->(f)
            CYPHER, [
            'game_id'        => $sqlGameId,
            'franchise_id'   => $sqlFranchiseId,
            'franchise_name' => $franchiseName,
        ]);
    }

    public function linkTags(int $sqlGameId, array $tags): void
    {
        foreach ($tags as $tag) {
            $this->client->run(<<<'CYPHER'
                MERGE (g:Game {sql_game_id: $game_id})
                MERGE (t:Tag {sql_tag_id: $tag_id})
                SET t.name = $tag_name
                MERGE (g)-[:HAS_TAG]->(t)
                CYPHER, [
                'game_id'  => $sqlGameId,
                'tag_id'   => $tag['sql_tag_id'],
                'tag_name' => $tag['name'],
            ]);
        }
    }
}