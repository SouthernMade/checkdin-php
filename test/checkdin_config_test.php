<?php
require_once 'inc/checkdin_config.php';

class CheckdinConfigTest {
  function test_version() {
    assert_equal(Checkdin\Config::VERSION, '0.1.0');
  }

  function test_api_endpoint() {
    $instance = new Checkdin\Config();
    $expected = 'https://app.checkd.in';
    $actual = $instance->apiBaseUrl();
    assert_equal($actual, $expected);
  }

  function test_clientID_required() {
    $instance = new Checkdin\Config();
    try {
      $instance->clientID();
      fail('Expected exception');
    } catch (Checkdin\ConfigError $e) {
      $success = true;
    }
    assert_equal($success, true);
  }

}

array_push($all_test_classes, 'CheckdinConfigTest');
?>