<?php
namespace Drupal\graphql_json\Plugin\GraphQL\Types;


use Drupal\graphql\Plugin\GraphQL\Types\TypePluginBase;
use Youshido\GraphQL\Execution\ResolveInfo;

/**
 * GraphQL type for json list nodes.
 *
 * @GraphQLType(
 *   id = "json_list",
 *   name = "JsonList",
 *   unions = {"JsonNode"}
 * )
 */
class JsonList extends TypePluginBase {

  /**
   * {@inheritdoc}
   */
  public function applies($value, ResolveInfo $info =  NULL) {
    return is_array($value) && count(array_filter(array_keys($value), 'is_string')) == 0;
  }

}
