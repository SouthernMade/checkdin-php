<?php
require_once 'inc/checkdin_api.php';

class CheckdinApiTest {
  function all_tests() {
    self::test_version();
  }

  function test_version() {
    assert_equal(CheckdinApi::VERSION, '0.0.1');
  }
}

array_push($all_test_classes, CheckdinApiTest);

?>