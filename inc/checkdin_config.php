<?php
class CheckdinConfigError extends Exception { }

class CheckdinConfig {
  const VERSION = '0.0.1';

  // API Credentials
  function clientID() {
    $clientId = 'TODO';
    return $this->ensureValueSet($clientId);
  }

  function clientSecret() {
    $clientSecret = 'TODO';
    return $this->ensureValueSet($clientSecret);
  }

  // API endpoint to connect to. Only change this if you are instructed to
  function apiUrl() {
    return 'https://app.checkd.in/api/v1';
  }

  function ensureValueSet($value) {
    if ($value == 'TODO') {
      throw new CheckdinConfigError("TODO: Open checkdin_config.php and insert your credentials, please");
    } else {
      $value;
    }
  }
}

?>