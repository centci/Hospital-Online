<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Admin controller
 */
class Admin extends Controller
{
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
      message('Please Login To View The Admin Section');
    }
    $user = New User();
    $data = $user->findAll();

    require $this->viewsPath("admin/dashboard/admin-home");
  }
}
