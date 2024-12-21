 <?php

/**
 * Main Controller Class
 */
class Controller
{
  public function viewsPath($view)
  {

    if (file_exists("../private/views/". $view .".view.php"))
    {
      return ("../private/views/". $view .".view.php");
    }else
    {
      return ("../private/views/404.view.php");
    }
  }

  public function redirect($link)
  {
    header("Location: " . ROOT ."/". trim($link, '/'));
    die();
  }
}
