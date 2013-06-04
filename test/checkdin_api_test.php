<?php
require_once 'inc/checkdin_api.php';

// A standin class useful for testing
class FakeConfig {
  function __construct($apiBaseUrl) {
    $this->apiBaseUrl = $apiBaseUrl;
  }

  function clientID() {
    return '99';
  }

  function clientSecret() {
    return '55';
  }

  function apiBaseUrl() {
    return $this->apiBaseUrl;
  }
}

class CheckdinApiTest {
  function all_tests() {
    self::test_version();
    self::test_default_config_instantiation();
    self::test_specific_config_instantiation();

    self::test_expand_url();
    self::test_expand_url_no_extra();
  }

  function test_version() {
    assert_equal(Checkdin\Api::VERSION, '0.0.1');
  }

  function test_default_config_instantiation() {
    $instance = new Checkdin\Api();
    $actual = $instance->apiUrlTemplate();
    $expected = 'https://app.checkd.in/api/v1{api_action}?client_id={client_id}&client_secret={client_secret}&{extra_arguments}';
    assert_equal($actual, $expected);
  }

  function test_specific_config_instantiation() {
    $expected_url = 'http://localhost:9030/api/v1{api_action}?client_id={client_id}&client_secret={client_secret}&{extra_arguments}';
    $config = new FakeConfig('http://localhost:9030');
    $instance = new Checkdin\Api($config);
    assert_equal($instance->apiUrlTemplate(), $expected_url);
  }

  function test_expand_url() {
    $config = new FakeConfig('http://localhost:9030');
    $instance = new Checkdin\Api($config);
    $data = array(
      'campaign_id' => 7,
      'page' => 3,
      'per_page' => 500
    );
    $actual = $instance->expandUrl("/campaigns/{campaign_id}/leaderboard.json", $data);
    $expected = 'http://localhost:9030/api/v1/campaigns/7/leaderboard.json?client_id=99&client_secret=55&page=3&per_page=500';
    assert_equal($actual, $expected);
  }

  function test_expand_url_no_extra() {
    $config = new FakeConfig('http://localhost:9030');
    $instance = new Checkdin\Api($config);
    $actual = $instance->expandUrl("/campaigns.json", array());
    $expected = 'http://localhost:9030/api/v1/campaigns.json?client_id=99&client_secret=55&';
    assert_equal($actual, $expected);
  }

}

array_push($all_test_classes, 'CheckdinApiTest');

?>