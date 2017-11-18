<?php

namespace Drupal\graphql_json\Plugin\GraphQL\Fields;

use Drupal\graphql_core\Plugin\GraphQL\Fields\Routing\ResponseContent;
use Youshido\GraphQL\Execution\ResolveInfo;

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

  protected function resolveValues($value, array $args, ResolveInfo $info) {
    foreach (parent::resolveValues($value, $args, $info) as $item) {
      if ($data = json_decode($item, TRUE)) {
        yield $data;
      }
    }
  }

}
