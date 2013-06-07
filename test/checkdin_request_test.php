<?php
require_once 'inc/checkdin_request.php';

class CheckdinRequestTest {

  function test_successful_get() {
    $instance = new Checkdin\Request();
    $result = $instance->performGet("http://httpbin.org/user-agent");
    assert_equal(
      $result,
      array('user-agent' => 'checkdin php client 0.0.1')
    );
  }

  function test_failed_get() {
    $instance = new Checkdin\Request();
    try {
      $instance->performGet("http://httpbin.org/status/400");
      fail("Expected exception");
    } catch (Checkdin\RequestError $e) {
      assert_match('/response_code=400/', $e->getMessage());
    }
  }

  function test_successful_post() {
    $instance = new Checkdin\Request();
    $result = $instance->performPost("http://httpbin.org/post", array(
      'email' => 'bob@example.com'
    ));
    assert_equal(
      $result['json'], # httpbin.org returns a neat JSON result
      array('email' => 'bob@example.com')
    );
  }

  function test_dns_error_reporting() {
    $instance = new Checkdin\Request();
    try {
      $instance->performGet('http://bad_hostname-expecting-no-match.com');
      fail("Expected exception");
    } catch (Checkdin\RequestError $e) {
      assert_match('/curl_errorno=6/', $e->getMessage());
    }
  }

  function test_user_agent() {
    $instance = new Checkdin\Request();
    assert_equal(substr($instance->getUserAgent(), 0, 22),
                 'checkdin php client 0.');
  }
}

array_push($all_test_classes, 'CheckdinRequestTest');
?>