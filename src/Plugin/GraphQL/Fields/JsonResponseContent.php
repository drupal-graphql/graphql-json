<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Fields;

use Drupal\graphql\GraphQL\Execution\ResolveContext;
use Drupal\graphql_core\Plugin\GraphQL\Fields\Routing\Response\ResponseContent;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Get the response content of an internal or external request as json object.
 *
 * @GraphQLField(
 *   id = "json_response_content",
 *   secure = true,
 *   name = "json",
 *   type = "JsonNode",
 *   parents = {"InternalResponse", "ExternalResponse"}
 * )
 */
class JsonResponseContent extends ResponseContent {

  /**
   * {@inheritdoc}
   */
  protected function resolveValues($value, array $args, ResolveContext $context, ResolveInfo $info) {
    foreach (parent::resolveValues($value, $args, $context, $info) as $item) {
      if ($data = json_decode($item, TRUE)) {
        yield $data;
      }
    }
  }

}
