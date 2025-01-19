<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Units controller
 */
class Units extends Controller
{
  // Units in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $units = new Unit();
    $errors = [];
    // view all saved Units in the database
    $data = $units->findAll();

    require $this->viewsPath("admin/Units/units");
  }

  //add Units to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }

    $units = new Unit();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($units->validate($_POST))
      {
        $_POST['unitUserId'] = Auth::getUserId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $units->insert($_POST);
        message('Unit Successfully Saved!');
        $this->redirect("Units");
      }
      else
      {
        // errors
        $errors = $units->errors;
      }
    }
    require $this->viewsPath("admin/Units/units-add");
  }

  //Edit Units in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $units = new Unit();
    $row = $units->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($units->validate($_POST))
      {
        $units->update($id,$_POST);
        message('Unit Edited Successfully!');
        $this->redirect("Units");
      }
      else
      {
        // errors
        $errors = $units->errors;
      }
    }
    require $this->viewsPath("admin/Units/units-edit");
  }
  //Delete Units in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $units = new Unit();
    $row = $units->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $units->delete($id,$_POST);
      message('Unit Deleted Successfully!');
      $this->redirect("Units");
    }
    require $this->viewsPath("admin/Units/units-delete");
  }
}
