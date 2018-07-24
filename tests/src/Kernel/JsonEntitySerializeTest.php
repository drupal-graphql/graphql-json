<?php

namespace Drupal\Tests\graphql_json\Kernel;


use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\Tests\graphql\Kernel\GraphQLFileTestBase;
use Drupal\Tests\graphql_core\Kernel\GraphQLContentTestBase;
use Drupal\user\Entity\Role;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Test traversing serialized entities.
 *
 * @group graphql_json
 */
class JsonEntitySerializeTest extends GraphQLContentTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'serialization',
    'graphql_json',
  ];

  /**
   * Test traversing serialized entities.
   */
  public function testJsonEntity() {
    $httpClient = $this->prophesize(ClientInterface::class);
    $httpClient
      ->request('GET', 'http://graphql.drupal/json')
      ->willReturn(new Response(200, [], json_encode([
        'node' => 'abc',
      ])));
    $this->container->set('http_client', $httpClient->reveal());

    $entityRepository = $this->prophesize(EntityRepositoryInterface::class);
    $entityRepository->loadEntityByUuid('node', 'abc')->willReturn(Node::create([
      'uuid' => 'abc',
      'type' => 'article',
      'status' => 1,
    ]));
    $this->container->set('entity.repository', $entityRepository->reveal());

    $query = $this->getQueryFromFile('serialize.gql');

    $this->assertResults($query, [], [
      'route' => [
        'request' => [
          'json' => [
            'node' => [
              'toJson' => [
                'uuid' => [
                  'value' => 'abc',
                ],
              ],
            ],
          ],
        ],
      ],
    ], $this->defaultCacheMetaData());
  }

}
