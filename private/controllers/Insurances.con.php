<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Insurance controller
 */
class Insurances extends Controller
{
  // Insurance in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $insurances = new Insurance();
    $errors = [];
    // view all saved Insurance in the database
    $data = $insurances->findAll();
// show($data);die;
    require $this->viewsPath("admin/settings/insurance");
  }

  //add Insurance to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }

    $insurances = new Insurance();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($insurances->validate($_POST))
      {
        $_POST['insuranceUserId'] = Auth::getUserId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $insurances->insert($_POST);
        message('Insurance Successfully Saved!');
        $this->redirect("insurances/add");
      }
      else
      {
        // errors
        $errors = $insurances->errors;
      }
    }
    require $this->viewsPath("admin/settings/insurance-add");
  }

  //Edit Insurance in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $insurances = new Insurance();
    $row = $insurances->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($insurances->validate($_POST))
      {
        $insurances->update($id,$_POST);
        message('Insurance Edited Successfully!');
        $this->redirect("insurances/edit/".$id);
      }
      else
      {
        // errors
        $errors = $insurances->errors;
      }
    }
    require $this->viewsPath("admin/settings/insurance-edit");
  }
  //Delete Insurance in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $insurances = new Insurance();
    $row = $insurances->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $insurances->delete($id,$_POST);
      message('Insurance Deleted Successfully!');
      $this->redirect("insurances");
    }
    require $this->viewsPath("admin/settings/insurance-delete");
  }
}
