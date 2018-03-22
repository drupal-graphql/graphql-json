<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Fields;

use Drupal\Component\Utility\NestedArray;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Fields\FieldPluginBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Traverse json objects with an array of path elements.
 *
 * @GraphQLField(
 *   id = "json_path",
 *   secure = true,
 *   name = "path",
 *   type = "JsonNode",
 *   parents = {"JsonObject", "JsonList"},
 *   arguments={
 *     "steps" = {
 *       "type" = "String",
 *       "multi" = true
 *     }
 *   }
 * )
 */
class JsonPath extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function resolveValues($value, array $args, ResolveContext $context, ResolveInfo $info) {
    yield NestedArray::getValue($value, $args['steps']);
  }

}
