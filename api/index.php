<?php
//database configuration file
require_once 'config/Connection.php';
require_once 'mainmodule/Index.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if ($uri[1] == "cms") {
  if (empty($uri[2])) {
    $action = "index";
  } else {
    $action = $uri[2];
  }

  $ViewController = new ViewController();
  if (method_exists($ViewController, $action)) {
    $ViewController->$action();
  } else {
    // Action not found
    header("HTTP/1.0 404 Not Found");
    exit();
  }
}
?>
