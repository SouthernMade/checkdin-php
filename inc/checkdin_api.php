<?php
namespace Checkdin;
require_once 'checkdin_config.php';

class Api {
  const VERSION = '0.0.1';

  private $config;
  private $requester;

  function __construct($config = NULL, $requester = NULL) {
    $this->config = $config ? $config : new Config();
    $this->requester = $requester ? $requester : new Request();
  }

  // invoke GET /api/v1/users.json
  function getUsers() {
    return $this->performGetRequest('users');
  }

  // invoke POST /api/v1/users.json
  function createUser($user_args) {
    return $this->performPostRequest('users', array(), $user_args);
  }

  // Get authentications for a user
  // invoke GET /api/v1/users/{user_id}/authentications.json
  function getUserAuthentications($user_id) {
    return $this->performGetRequest(
      'users/{user_id}/authentications',
      array('user_id' => $user_id)
    );
  }

  // Get details for a single authentication for a user
  // invoke GET /api/v1/users/{user_id}/authentications/{authentication_id}.json
  function getUserAuthentication($user_id, $authentication_id) {
    return $this->performGetRequest(
      'users/{user_id}/authentications/{authentication_id}',
      array(
        'user_id' => $user_id,
        'authentication_id' => $authentication_id
      )
    );
  }

  // Create or update an authentication for a user
  // invoke POST /api/v1/users/{user_id}/authentications.json
  function createUserAuthentication($user_id, $authentication_args) {
    return $this->performPostRequest(
      'users/{user_id}/authentications',
      array('user_id' => $user_id),
      $authentication_args
    );
  }

  // Internal: Expand the url and perform the given GET request
  function performGetRequest($url_action, $url_params = NULL) {
    return $this->requester->performGet(
      $this->expandUrl($url_action, $url_params)
    );
  }

  // Internal: Expand the url and perform the given POST request
  function performPostRequest($url_action, $url_params, $body_payload) {
    return $this->requester->performPost(
      $this->expandUrl($url_action, $url_params),
      $body_payload
    );
  }

  // Internal: Template string for all valid API URLs
  function apiUrlTemplate() {
    $base = $this->config->apiBaseUrl();
    return "{$base}/api/v1/{api_action}.json?client_id={client_id}&client_secret={client_secret}&{extra_arguments}";
  }

  // Internal: Build a full URL for invoking an API action
  function expandUrl($api_action, $url_params) {
    if (!$url_params) {
      $url_params = array();
    }

    $result = $this->apiUrlTemplate();
    $result = str_replace('{api_action}', $api_action, $result);
    $result = str_replace('{client_id}', $this->config->clientID(), $result);
    $result = str_replace('{client_secret}', $this->config->clientSecret(), $result);

    $extra_arguments = array();

    foreach ($url_params as $url_param => $value) {
      $replace_key = "{{$url_param}}";
      if (strpos($result, $replace_key)) {
        $result = str_replace($replace_key, $value, $result);
      } else {
        $extra_arguments[$url_param] = $value;
      }
    }
    $result = str_replace('{extra_arguments}',
                          http_build_query($extra_arguments),
                          $result);

    return $result;
  }

}
?>