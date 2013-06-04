<?php
require_once 'inc/checkdin_request.php';

class CheckdinRequestTest {

  function test_user_agent() {
    $instance = new Checkdin\Request();
    assert_equal(substr($instance->getUserAgent(), 0, 22),
                 'checkdin php client 0.');
  }
}

array_push($all_test_classes, 'CheckdinRequestTest');
?>