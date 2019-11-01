<?php

namespace Drupal\Tests\graphql_json\Kernel;

use Drupal\Tests\graphql_core\Kernel\GraphQLCoreTestBase;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Test json data spanning multiple urls.
 *
 * @group graphql_json
 */
class JsonUrlTest extends GraphQLCoreTestBase {

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
   * Test json data spanning multiple urls.
   */
  public function testJsonUrl() {
    $httpClient = $this->prophesize(ClientInterface::class);

    $httpClient
      ->request('GET', 'http://graphql.drupal/json')
      ->willReturn(new Response(200, [], json_encode([
        'url' => 'http://graphql.drupal/json/sub',
      ])));

    $httpClient
      ->request('GET', 'http://graphql.drupal/json/sub')
      ->willReturn(new Response(200, [], json_encode("test")));


    $this->container->set('http_client', $httpClient->reveal());

    $query = $this->getQueryFromFile('url.gql');

    $this->assertResults($query, [], [
      'route' => [
        'request' => [
          'json' => [
            'url' => [
              'request' => [
                'json' => [
                  'value' => 'test',
                ],
              ],
            ],
          ],
        ],
      ],
    ], $this->defaultCacheMetaData());
  }

}
