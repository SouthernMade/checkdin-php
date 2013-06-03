<?php
require_once 'inc/checkdin_api.php';

// A standin class useful for testing
class FakeConfig {
  function __construct($apiUrl) {
    $this->apiUrl = $apiUrl;
  }

  function apiUrl() {
    return $this->apiUrl;
  }
}

class CheckdinApiTest {
  function all_tests() {
    self::test_version();
    self::test_default_config_instantiation();
    self::test_specific_config_instantiation();
  }

  function test_version() {
    assert_equal(CheckdinApi::VERSION, '0.0.1');
  }

  function test_default_config_instantiation() {
    $instance = new CheckdinApi();
    $actual = $instance->apiUrl();
    $expected = 'https://app.checkd.in/api/v1';
    assert_equal($actual, $expected);
  }

  function test_specific_config_instantiation() {
    $expected_url = 'http://localhost:9030/api/v1';
    $config = new FakeConfig($expected_url);
    $instance = new CheckdinApi($config);
    assert_equal($instance->apiUrl(), $expected_url);
  }
}

array_push($all_test_classes, CheckdinApiTest);

?>