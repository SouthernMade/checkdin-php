<?php
namespace Checkdin;
require_once 'checkdin_api.php';

class RequestError extends \Exception { }

class Request {
  function performGet($url) {
    return $this->perform('GET', $url, array());
  }

  function performPost($url, $request_body) {
    return $this->perform('POST', $url, $request_body);
  }

  // Internal: perform a request for the given $url with the given HTTP
  // $method and the optional $request_body array
  function perform($method, $url, $request_body) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT, $this->getUserAgent());
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_VERBOSE, true); // DEBUG ONLY

    if ($method == 'POST') {
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request_body));
    }

    $response_body = curl_exec($curl);
    $response_info = curl_getinfo($curl);
    $response_code = $response_info['http_code'];
    $driver_error = curl_errno($curl);

    curl_close($curl);

    return $this->parseResponse($response_code, $response_body, $driver_error);
  }

  // Internal: parse response as JSON or raise an exception on server-reported error
  function parseResponse($response_code, $response_body, $driver_error) {
    if ($this->successfulResponse($response_code)) {
      return json_decode($response_body, true);
    } else {
      $error_message = "Error performing request. response_code={$response_code} body={$response_body}";
      if ($driver_error != 0) {
        $error_message .= " curl_errorno={$driver_error}";
      }
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