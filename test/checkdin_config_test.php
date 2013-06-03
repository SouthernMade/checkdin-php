<?php
require_once 'inc/checkdin_config.php';

class CheckdinConfigTest {
  function all_tests() {
    self::test_version();
  }

  function test_version() {
    assert_equal(CheckdinConfig::VERSION, '0.0.1');
  }

}

$instance = new CheckdinConfigTest();
$instance->all_tests();

?>