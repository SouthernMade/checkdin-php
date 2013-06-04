<?php
require_once 'inc/checkdin_api.php';

// A standin class useful for testing
class FakeConfig {
  function __construct($apiBaseUrl) {
    $this->apiBaseUrl = $apiBaseUrl;
  }

  function apiBaseUrl() {
    return $this->apiBaseUrl;
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
    $actual = $instance->apiUrlTemplate();
    $expected = 'https://app.checkd.in/api/v1{api_action}?client_id={client_id}&client_secret={client_secret}&{extra_arguments}';
    assert_equal($actual, $expected);
  }

  function test_specific_config_instantiation() {
    $expected_url = 'http://localhost:9030/api/v1{api_action}?client_id={client_id}&client_secret={client_secret}&{extra_arguments}';
    $config = new FakeConfig('http://localhost:9030');
    $instance = new CheckdinApi($config);
    assert_equal($instance->apiUrlTemplate(), $expected_url);
  }

}

array_push($all_test_classes, 'CheckdinApiTest');

?>