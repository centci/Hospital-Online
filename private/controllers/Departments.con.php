<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Department controller
 */
class Departments extends Controller
{
  // Department in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $departments = New Department();
    $errors = [];
    // view all saved Department in the database
    $data = $departments->findAll();

    require $this->viewsPath("admin/settings/department");
  }

  //add Department to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }

    $departments = New Department();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($departments->validate($_POST)) 
      {
        $_POST['userId'] = Auth::getId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $departments->insert($_POST);
        message('Department Successfully Saved!');
        $this->redirect("departments");
      }
      else
      {
        // errors
        $errors = $departments->errors;
      }
    }
    require $this->viewsPath("admin/settings/department-add");
  }

  //Edit Department in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $departments = New Department();
    $row = $departments->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($departments->validate($_POST))
      {
        $departments->update($id,$_POST);
        message('Department Edited Successfully!');
        $this->redirect("departments");
      }
      else
      {
        // errors
        $errors = $departments->errors;
      }
    }
    require $this->viewsPath("admin/settings/department-edit");
  }
  //Delete Department in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $departments = New Department();
    $row = $departments->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $departments->delete($id,$_POST);
      message('Department Deleted Successfully!');
      $this->redirect("departments");
    }
    require $this->viewsPath("admin/settings/department-delete");
  }
}
