<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Fields;

use Drupal\file\FileInterface;
use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql\Plugin\GraphQL\Fields\FieldPluginBase;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Expose json file contents.
 *
 * @GraphQLField(
 *   id = "json_file",
 *   name = "json",
 *   secure = true,
 *   type = "JsonNode",
 *   parents = {"File"},
 * )
 */
class JsonFile extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  protected function resolveValues($value, array $args, ResolveContext $context, ResolveInfo $info) {
    if ($value instanceof FileInterface) {
      if ($content = file_get_contents($value->getFileUri())) {
        yield json_decode($content, TRUE);
      }
    }
  }

}
