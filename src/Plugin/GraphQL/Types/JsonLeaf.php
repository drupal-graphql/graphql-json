<?php
namespace Drupal\graphql_json\Plugin\GraphQL\Types;


use Drupal\graphql\Plugin\GraphQL\Types\TypePluginBase;
use Drupal\graphql\Plugin\GraphQL\TypeValidationInterface;
use Youshido\GraphQL\Execution\ResolveInfo;

/**
 * GraphQL type for json list nodes.
 *
 * @GraphQLType(
 *   id = "json_leaf",
 *   name = "JsonLeaf",
 *   unions = {"JsonNode"}
 * )
 */
class JsonLeaf extends TypePluginBase implements TypeValidationInterface {

  /**
   * {@inheritdoc}
   */
  public function isValidValue($value) {
    return !(is_object($value) || is_array($value));
  }

  /**
   * {@inheritdoc}
   */
  public function applies($value, ResolveInfo $info =  NULL) {
    return !is_array($value);
  }


}