<?php
require_once 'inc/checkdin_api.php';

class CheckdinApiTest {
  function all_tests() {
    self::test_version();
    self::test_default_config_instantiation();
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
}

array_push($all_test_classes, CheckdinApiTest);

?>