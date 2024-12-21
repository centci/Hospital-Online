<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Samples controller
 */
class Samples extends Controller
{
  // Samples in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $samples = New Sample();
    $errors = [];
    // view all saved Samples in the database
    $data = $samples->findAll();

    require $this->viewsPath("admin/Samples/samples");
  }

  //add Samples to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }

    $samples = New Sample();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($samples->validate($_POST))
      {
        $_POST['userId'] = Auth::getId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $samples->insert($_POST);
        message('Sample Successfully Saved!');
        $this->redirect("Samples");
      }
      else
      {
        // errors
        $errors = $samples->errors;
      }
    }
    require $this->viewsPath("admin/Samples/samples-add");
  }

  //Edit Samples in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $samples = New Sample();
    $row = $samples->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($samples->validate($_POST))
      {
        $samples->update($id,$_POST);
        message('Sample Edited Successfully!');
        $this->redirect("Samples");
      }
      else
      {
        // errors
        $errors = $samples->errors;
      }
    }
    require $this->viewsPath("admin/Samples/samples-edit");
  }
  //Delete Samples in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $samples = New Sample();
    $row = $samples->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $samples->delete($id);
      message('Sample Deleted Successfully!');
      $this->redirect("Samples");
    }
    require $this->viewsPath("admin/Samples/samples-delete");
  }
}
