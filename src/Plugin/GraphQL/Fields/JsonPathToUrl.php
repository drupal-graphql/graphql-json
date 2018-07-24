<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Fields;

use Drupal\Component\Utility\NestedArray;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql_core\Plugin\GraphQL\Fields\Routing\Route;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Extract Url objects from json paths.
 *
 * @GraphQLField(
 *   id = "json_path_url",
 *   name = "pathToUrl",
 *   secure = true,
 *   type = "Url",
 *   parents = {"JsonObject", "JsonList"},
 *   arguments={
 *     "steps" = {
 *       "type" = "String",
 *       "multi" = true
 *     }
 *   }
 * )
 */
class JsonPathToUrl extends Route {

  /**
   * {@inheritdoc}
   */
  public function resolve($value, array $args, ResolveContext $context, ResolveInfo $info) {
    foreach (parent::resolveValues(NULL, ['path' => NestedArray::getValue($value, $args['steps'])], $context, $info) as $item) {
      return $item;
    }
  }

}
