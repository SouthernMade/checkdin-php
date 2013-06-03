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

  function apiUrl() {
    return $this->config->apiUrl();
  }
}
?>