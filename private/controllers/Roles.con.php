<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Roles controller
 */
class Roles extends Controller
{
  // Roles in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $role = New Role();
    $errors = [];
    // view all saved Roles in the database
    $data = $role->findAll();

    require $this->viewsPath("admin/settings/role");
  }

  //add Roles to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }

    $role = New Role();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($role->validate($_POST))
      {
        $_POST['userId'] = Auth::getId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $role->insert($_POST);
        message('Role Successfully Saved!');
        $this->redirect("Roles");
      }
      else
      {
        // errors
        $errors = $role->errors;
      }
    }
    require $this->viewsPath("admin/settings/role-add");
  }

  //Edit Roles in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $role = New Role();
    $row = $role->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($role->validate($_POST))
      {
        $role->update($id,$_POST);
        message('Role Edited Successfully!');
        $this->redirect("Roles");
      }
      else
      {
        // errors
        $errors = $role->errors;
      }
    }
    require $this->viewsPath("admin/settings/role-edit");
  }
  //Delete Roles in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $role = New Role();
    $row = $role->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $role->delete($id,$_POST);
      message('Role Deleted Successfully!');
      $this->redirect("Roles");
    }
    require $this->viewsPath("admin/settings/role-delete");
  }
}
