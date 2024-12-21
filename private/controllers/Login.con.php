<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Login controller
 */
class Login extends Controller
{

  public function index($id = null)
  {
  	$errors = [];

    if(count($_POST) > 0)
    {
      $user = New User();
      $row = $user->where('email',$_POST['email']);
      if($row)
      {
        $row = $row[0];
        $decriptPassword = password_verify($_POST['password'],$row->password);

        if ($decriptPassword)
        {
          Auth::authenticate($row);
          $this->redirect('home');
        }
        else
        {
          $errors['password'] = 'Seems You Entered Wrong Password, Try Again!';
        }
      }
      elseif(empty($_POST['email']))
      {
        $errors['email'] = 'Please Enter Email!';
      }else {
        $errors['email'] = 'Please Check Your Email and Try Again!';
      }
    }
    require $this->viewsPath("auth/login");
  }
}
