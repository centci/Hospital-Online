<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Containers controller
 */
class Containers extends Controller
{
  // Containers in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $containers = new Container();
    $errors = [];
    // view all saved Containers in the database
    $data = $containers->findAll();
// show($data);die;
    require $this->viewsPath("admin/Containers/containers");
  }

  //add Containers to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Login To Access Page!');
      $this->redirect('login');
    }

    $containers = new Container();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($containers->validate($_POST))
      {
        $_POST['containerUserId'] = Auth::getUserId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $containers->insert($_POST);
        message('Container Successfully Saved!');
        $this->redirect("Containers");
      }
      else
      {
        // errors
        $errors = $containers->errors;
      }
    }
    require $this->viewsPath("admin/Containers/containers-add");
  }

  //Edit Containers in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Login To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $containers = new Container();
    $row = $containers->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($containers->validate($_POST))
      {
        $containers->update($id,$_POST);
        message('Container Edited Successfully!');
        $this->redirect("Containers");
      }
      else
      {
        // errors
        $errors = $containers->errors;
      }
    }
    require $this->viewsPath("admin/Containers/containers-edit");
  }
  //Delete Containers in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Login To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $containers = new Container();
    $row = $containers->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $containers->delete($id);
      message('Container Deleted Successfully!');
      $this->redirect("Containers");
    }
    require $this->viewsPath("admin/Containers/containers-delete");
  }
}
