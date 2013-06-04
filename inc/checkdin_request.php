<?php
namespace Checkdin;
require_once 'checkdin_api.php';

class RequestError extends \Exception { }

class Request {
  function performGet($url) {
    return $this->perform('GET', $url, array());
  }

  function perform($method, $url, $request_body) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT, $this->getUserAgent());
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response_body = curl_exec($curl);
    $response_info = curl_getinfo($curl);
    $response_code = $response_info['http_code'];

    curl_close($curl);

    return $this->parseResponse($response_code, $response_body);
  }

  // Internal: parse response as JSON or raise an exception on server-reported error
  function parseResponse($response_code, $response_body) {
    if ($this->successfulResponse($response_code)) {
      return json_decode($response_body, true);
    } else {
      $error_message = "Error performing request. response_code={$response_code} body={$response_body}";
      throw new RequestError($error_message);
    }
  }

  // Internal: is the response-code deemed a success? All 2xx codes are accepted.
  function successfulResponse($response_code) {
    return ($response_code / 100) == 2;
  }

  // Internal: User-Agent to send to the server
  function getUserAgent() {
    $version = Api::VERSION;
    return "checkdin php client {$version}";
  }
}
?>