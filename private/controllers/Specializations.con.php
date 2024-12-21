<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Specializations controller
 */
class Specializations extends Controller
{
  // Specialization in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $specialized = New Specialization();
    $errors = [];
    // view all saved Specialization in the database
    $data = $specialized->findAll();

    require $this->viewsPath("admin/settings/specialized");
  }

  //add Specialization to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }

    $specialized = New Specialization();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($specialized->validate($_POST))
      {
        $_POST['userId'] = Auth::getId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $specialized->insert($_POST);
        message('Specialization Successfully Saved!');
        $this->redirect("specializations");
      }
      else
      {
        // errors
        $errors = $specialized->errors;
      }
    }
    require $this->viewsPath("admin/settings/specialized-add");
  }

  //Edit Specialization in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $specialized = New Specialization();
    $row = $specialized->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($specialized->validate($_POST))
      {
        $specialized->update($id,$_POST);
        message('Specialization Edited Successfully!');
        $this->redirect("specializations");
      }
      else
      {
        // errors
        $errors = $specialized->errors;
      }
    }
    require $this->viewsPath("admin/settings/specialized-edit");
  }
  //Delete Specialization in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $specialized = New Specialization();
    $row = $specialized->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $specialized->delete($id,$_POST);
      message('Specialization Deleted Successfully!');
      $this->redirect("specializations");
    }
    require $this->viewsPath("admin/settings/specialized-delete");
  }
}
