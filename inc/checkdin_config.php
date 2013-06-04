<?php
class CheckdinConfigError extends Exception { }

class CheckdinConfig {
  const VERSION = '0.1.0';

  // API Credentials. Replace the TODO string with your actual value
  function clientID() {
    $clientId = 'TODO';
    return self::ensureValueSet($clientId);
  }

  // API Credentials. Replace the TODO string with your actual value
  function clientSecret() {
    $clientSecret = 'TODO';
    return self::ensureValueSet($clientSecret);
  }

  // API endpoint to connect to. Only change this if you are instructed to
  function apiBaseUrl() {
    $protocol = 'https';
    $hostname = 'app.checkd.in';
    return "{$protocol}://{$hostname}";
  }

  // Internal bouncer method to ensure the value is configured
  function ensureValueSet($value) {
    if ($value == 'TODO') {
      throw new CheckdinConfigError("TODO: Open checkdin_config.php and insert your credentials, please");
    } else {
      $value;
    }
  }
}

?>