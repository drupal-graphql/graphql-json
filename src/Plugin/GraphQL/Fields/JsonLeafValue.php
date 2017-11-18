<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Fields;

use Drupal\graphql\Plugin\GraphQL\Fields\FieldPluginBase;
use Youshido\GraphQL\Execution\ResolveInfo;

/**
 * Retrieve json leaf values.
 *
 * @GraphQLField(
 *   id = "json_leaf_value",
 *   secure = true,
 *   name = "value",
 *   type = "String",
 *   parents = {"JsonLeaf"}
 * )
 */
class JsonLeafValue extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function resolveValues($value, array $args, ResolveInfo $info) {
    yield (string) $value;
  }

}