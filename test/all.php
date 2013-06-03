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

require_once "checkdin_config_test.php";

echo "ok\n";

?>