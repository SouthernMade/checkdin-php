<?php
namespace Checkdin;
require_once 'checkdin_api.php';

class RequestError extends \Exception { }

class Request {


  // Internal: User-Agent to send to the server
  function getUserAgent() {
    $version = Api::VERSION;
    return "checkdin php client {$version}";
  }
}
?>