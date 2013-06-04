<?php
require_once 'checkdin_config.php';

class CheckdinApi {
  const VERSION = '0.0.1';

  private $config;

  function __construct($config = NULL) {
    if ($config) {
      $this->config = $config;
    } else {
      $this->config = new CheckdinConfig();
    }
  }

  function apiUrlTemplate() {
    $base = $this->config->apiBaseUrl();
    return "{$base}/api/v1{api_action}?client_id={client_id}&client_secret={client_secret}&{extra_arguments}";
  }

}
?>