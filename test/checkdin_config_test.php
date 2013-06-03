<?php
require_once 'inc/checkdin_config.php';

class CheckdinConfigTest {
  function all_tests() {
    self::test_version();
    self::test_api_endpoint();
    self::test_clientID_required();
  }

  function test_version() {
    assert_equal(CheckdinConfig::VERSION, '0.1.0');
  }

  function test_api_endpoint() {
    $instance = new CheckdinConfig();
    $expected = 'https://app.checkd.in/api/v1';
    $actual = $instance->apiUrl();
    assert_equal($actual, $expected);
  }

  function test_clientID_required() {
    $instance = new CheckdinConfig();
    try {
      $instance->clientID();
      fail('Expected exception');
    } catch (CheckdinConfigError $e) {
      $success = true;
    }
    assert_equal($success, true);
  }

}

array_push($all_test_classes, CheckdinConfigTest);
?>