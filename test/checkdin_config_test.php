<?php
require_once 'inc/checkdin_config.php';

class CheckdinConfigTest {
  function all_tests() {
    self::test_version();
    self::test_api_endpoint();
  }

  function test_version() {
    assert_equal(CheckdinConfig::VERSION, '0.0.1');
  }

  function test_api_endpoint() {
    $instance = new CheckdinConfig();
    $expected = 'https://app.checkd.in/api/v1';
    $actual = $instance->apiUrl();
    assert_equal($actual, $expected);
  }

}

$instance = new CheckdinConfigTest();
$instance->all_tests();

?>