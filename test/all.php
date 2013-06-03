<?php
error_reporting(E_ALL & E_STRICT);

function assert_equal($actual, $expected, $message = 'Assertion failed') {
  if ($actual != $expected) {
    echo "Error: {$message}\n";
    echo "Expected: ";
    print_r($expected);
    echo "\nActual:   ";
    print_r($actual);
    exit(1);
  }
}

echo "ok\n";

?>