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

  // Get point account entries
  // invoke GET /api/v1/point_account_entries.json
  // Allowed filter options:
  //   'user_id', 'point_account_id', 'campaign_id'
  // This means you can pass in:
  //   array('user_id' => 37)
  // and only get point account entries for that $user_id
  function getPointAccountEntries($restrictions) {
    return $this->performGetRequest(
      'point_account_entries',
      $restrictions
    );
  }

  // Create a custom activity
  // invoke POST /api/v1/custom_activities.json
  function createCustomActivity($user_id, $user_email, $custom_activity_node_id) {
    return $this->performPostRequest(
      'custom_activities',
      array(),
      array(
        'user_id' => $user_id,
        'email' => $user_email,
        'custom_activity_node_id' => $custom_activity_node_id
      )
    );
  }

  // Get all campaigns
  // invoke GET /api/v1/campaigns.json
  function getCampaigns() {
    return $this->performGetRequest('campaigns');
  }

  // Get details for a single campaign
  // invoke GET /api/v1/campaign/{campaign_id}.json
  function getCampaign($campaign_id) {
    return $this->performGetRequest(
      'campaigns/{campaign_id}',
      array('campaign_id' => $campaign_id)
    );
  }

  // Get leaderboard for a single campaign
  // invoke GET /api/v1/campaign/{campaign_id}/leaderboard.json
  function getCampaignLeaderboard($campaign_id) {
    return $this->performGetRequest(
      'campaigns/{campaign_id}/leaderboard',
      array('campaign_id' => $campaign_id)
    );
  }

  // Get recent activities
  // invoke GET /api/v1/activities.json
  // Quite a lot of filteres are available for this, please see documentation
  function getActivities($filters) {
    return $this->performGetRequest('activities', $filters);
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