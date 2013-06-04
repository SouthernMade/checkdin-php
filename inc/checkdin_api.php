<?php
namespace Checkdin;
require_once 'checkdin_config.php';

class Api {
  const VERSION = '0.0.1';

  private $config;

  function __construct($config = NULL) {
    if ($config) {
      $this->config = $config;
    } else {
      $this->config = new Config();
    }
  }

  // Internal: Template string for all valid API URLs
  function apiUrlTemplate() {
    $base = $this->config->apiBaseUrl();
    return "{$base}/api/v1{api_action}?client_id={client_id}&client_secret={client_secret}&{extra_arguments}";
  }

  // Internal: Build a full URL for invoking an API action
  function expandUrl($api_action, $url_params) {
    $result = $this->apiUrlTemplate();
    $result = str_replace('{api_action}', $api_action, $result);
    $result = str_replace('{client_id}', $this->config->clientID(), $result);
    $result = str_replace('{client_secret}', $this->config->clientSecret(), $result);

    $extra_arguments = array();
    foreach ($url_params as $url_param => $value) {
      $replace_key = "{{$url_param}}";
      if (strpos($result, $replace_key)) {
        $result = str_replace($replace_key, $value, $result);
      } else {
        $extra_arguments[$url_param] = $value;
      }
    }
    $result = str_replace('{extra_arguments}',
                          http_build_query($extra_arguments),
                          $result);

    return $result;
  }

}
?>