<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Fields;

use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Fields\FieldPluginBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Retrieve json list items.
 *
 * @GraphQLField(
 *   id = "json_list_items",
 *   secure = true,
 *   name = "items",
 *   type = "JsonNode",
 *   multi = true,
 *   parents = {"JsonList"}
 * )
 */
class JsonListItems extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function resolveValues($value, array $args, ResolveContext $context, ResolveInfo $info) {
    foreach ($value as $item) {
      yield $item;
    }
  }

}
