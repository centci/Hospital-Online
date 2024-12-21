<?php

/**
 * Main App Class
 */
class App
{
  protected $controller   = "home";
  protected $method       = "index";
  protected $params       = [];

  public function __construct()
  {
    $URL = $this->getURL();
    // Get the first item from the URL
    if (file_exists("../private/controllers/".$URL[0].".con.php"))
    {
      $this->controller = ucfirst($URL[0]);
      unset($URL[0]);
    }else {
      echo "<center><h1>Controller Not Found</h1></center>";
      die;
    }
    require "../private/controllers/".$this->controller.".con.php";
    $this->controller = New $this->controller();
    if (isset($URL[1]))
    {
      if (method_exists($this->controller, $URL[1]))
      {
        $this->method = ucfirst($URL[1]);
        unset($URL[1]);
      }
    }
    $URL = array_values($URL);
    $this->params = $URL;

    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  private function getURL()
  {
    $url = isset($_GET['url']) ? $_GET['url'] : "home";
    return explode("/", filter_var(trim($url, "/")), FILTER_SANITIZE_URL);
  }
}
