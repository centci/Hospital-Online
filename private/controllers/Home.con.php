<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Home controller
 */
class Home extends Controller
{
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }
    $user = New User();

    $data = $user->findAll();

    require $this->viewsPath("home");
  }
}
