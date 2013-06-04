<?php
error_reporting(-1);

$assertions_failed = 0;
function assert_equal($actual, $expected, $message = 'Assertion failed') {
  if ($actual != $expected) {
    echo "Error: {$message}\n";
    echo "Expected: ";
    print_r($expected);
    echo "\nActual:   ";
    print_r($actual);
    echo "\n\n";

    global $assertions_failed;
    $assertions_failed++;
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

function run_tests() {
  $all_test_classes = [];
  require_once "checkdin_config_test.php";
  require_once "checkdin_api_test.php";
  array_walk($all_test_classes, 'run_all_tests');

  report_result();
}

function report_result() {
  global $assertions_failed;
  if ($assertions_failed > 0) {
    fail("assert_equal failed");
  } else {
    echo "\nok\n";
  }
}

run_tests();
?>