<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Types;


use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Types\TypePluginBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * GraphQL type for json list nodes.
 *
 * @GraphQLType(
 *   id = "json_leaf",
 *   name = "JsonLeaf",
 *   unions = {"JsonNode"}
 * )
 */
class JsonLeaf extends TypePluginBase {

  /**
   * {@inheritdoc}
   */
  public function applies($value, ResolveContext $context, ResolveInfo $info) {
    return !is_array($value);
  }

}
