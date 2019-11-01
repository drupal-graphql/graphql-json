<?php

namespace Drupal\Tests\graphql_json\Kernel;


use Drupal\Tests\graphql_core\Kernel\GraphQLCoreTestBase;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Test json data retrieval.
 *
 * @group graphql_json
 */
class JsonStructureTest extends GraphQLCoreTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'graphql_json',
  ];

  /**
   * {@inheritdoc}
   */
  protected function defaultCacheTags() {
    return [
      'graphql',
    ];
  }

  /**
   * Ensure that all leave types are casted into strings.
   */
  public function testJsonLeaf() {
    $httpClient = $this->prophesize(ClientInterface::class);

    $httpClient
      ->request('GET', 'http://graphql.drupal/json/string')
      ->willReturn(new Response(200, [], json_encode("test")));

    $httpClient
      ->request('GET', 'http://graphql.drupal/json/int')
      ->willReturn(new Response(200, [], json_encode(1)));

    $httpClient
      ->request('GET', 'http://graphql.drupal/json/float')
      ->willReturn(new Response(200, [], json_encode(0.5)));

    $httpClient
      ->request('GET', 'http://graphql.drupal/json/bool')
      ->willReturn(new Response(200, [], json_encode(TRUE)));

    $this->container->set('http_client', $httpClient->reveal());

    $query = $this->getQueryFromFile('leaves.gql');

    $this->assertResults($query, [], [
      'string' => ['request' => ['json' => ['value' => 'test']]],
      'int' => ['request' => ['json' => ['value' => '1']]],
      'float' => ['request' => ['json' => ['value' => '0.5']]],
      'bool' => ['request' => ['json' => ['value' => '1']]],
    ], $this->defaultCacheMetaData());
  }

  /**
   * Test object traversal.
   */
  public function testJsonObject() {
    $httpClient = $this->prophesize(ClientInterface::class);

    $httpClient
      ->request('GET', 'http://graphql.drupal/json/object')
      ->willReturn(new Response(200, [], json_encode([
        'a' => 'A',
        'b' => 'B',
        'c' => 'C',
      ])));

    $this->container->set('http_client', $httpClient->reveal());

    $query = $this->getQueryFromFile('object.gql');

    $this->assertResults($query, [], [
      'route' => [
        'request' => [
          'json' => [
            'keys' => ['a', 'b', 'c'],
            'a' => ['value' => 'A'],
            'b' => ['value' => 'B'],
          ],
        ],
      ],
    ], $this->defaultCacheMetaData());
  }

  /**
   * Test list traversal.
   */
  public function testJsonList() {
    $httpClient = $this->prophesize(ClientInterface::class);

    $httpClient
      ->request('GET', 'http://graphql.drupal/json/list')
      ->willReturn(new Response(200, [], json_encode(['A', 'B', 'C'])));

    $this->container->set('http_client', $httpClient->reveal());

    $query = $this->getQueryFromFile('list.gql');
    $this->assertResults($query, [], [
      'route' => [
        'request' => [
          'json' => [
            'a' => ['value' => 'A'],
            'b' => ['value' => 'B'],
            'items' => [
              ['value' => 'A'],
              ['value' => 'B'],
              ['value' => 'C'],
            ],
          ],
        ],
      ],
    ], $this->defaultCacheMetaData());
  }

}
