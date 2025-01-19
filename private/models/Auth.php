<?php
/**
 * Authentication class
 */
class Auth
{
  public static function authenticate($row)
  {
    if (is_array($row)) {
        $row = (object) $row; // Convert associative array to object
    }
    $_SESSION['USER'] = $row;
  }

  public static function logged_in()
  {
    if(isset($_SESSION['USER']))
    {
      return true;
    }
    return false;
  }

  public static function logout()
  {
    if(isset($_SESSION['USER']))
    {
      unset($_SESSION['USER']);
    }
  }

  public static function user()
  {
    if(isset($_SESSION['USER']))
    {
      return $_SESSION['USER']->userId;
    }
    return false;
  }

  public static function __callStatic($method, $params)
  {
    $prop = lcfirst(str_replace('get', '', $method));

    if(isset($_SESSION['USER']->$prop))
    {
      return $_SESSION['USER']->$prop;
    }
    return 'Unknown';
  }

}
