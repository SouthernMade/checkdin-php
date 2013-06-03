<?php
error_reporting(E_ALL & E_STRICT);

function assert_equal($actual, $expected, $message = 'Assertion failed') {
  if ($actual != $expected) {
    echo "Error: {$message}\n";
    echo "Expected: ";
    print_r($expected);
    echo "\nActual:   ";
    print_r($actual);
    echo "\n\n";
    fail("assert_equal failed");
  }
}

function fail($message = 'fail called') {
  echo("fail: " . $message . "\n\n");
  exit(1);
}

function run_all_tests($test_class) {
  $test_instance = new $test_class();
  $test_instance->all_tests();
}

$all_test_classes = [];
require_once "checkdin_config_test.php";
require_once "checkdin_api_test.php";
array_walk($all_test_classes, 'run_all_tests');

echo "ok\n";

?>