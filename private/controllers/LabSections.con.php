<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * LabSections controller
 */
class LabSections extends Controller
{
  // Laboratory in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $labSec = new LabSection();
    $user = new User();
    $errors = [];
    // view all saved lab department in the database
    $data = $labSec->findAll();
    // show($data);die;

    require $this->viewsPath("admin/labsections/lab-section");
  }

  //add Laboratory to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }

    $labSec = new LabSection();
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($labSec->validate($_POST))
      {
        $_POST['labSectionUserId'] = Auth::getUserId();
        $_POST['date'] = date('Y-m-d H:i:s');
        $labSec->insert($_POST);
        message('Lab Section Successfully Saved!');
        $this->redirect("LabSections");
      }
      else
      {
        // errors
        $errors = $labSec->errors;
      }
    }
    require $this->viewsPath("admin/labsections/lab-section-add");
  }

  //Edit Laboratory in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $labSec = new LabSection();
    $row = $labSec->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($labSec->validate($_POST))
      {
        $labSec->update($id,$_POST);
        message('Lab Section Edited Successfully!');
        $this->redirect("LabSections");
      }
      else
      {
        // errors
        $errors = $labSec->errors;
      }
    }
    require $this->viewsPath("admin/labsections/lab-section-edit");
  }
  //Delete Laboratory in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access Page!');
      $this->redirect('login');
    }
    $errors = [];
    $labSec = new LabSection();
    $row = $labSec->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $labSec->delete($id,$_POST);
      message('Lab Section Deleted Successfully!');
      $this->redirect("LabSections");
    }
    require $this->viewsPath("admin/labsections/lab-section-delete");
  }
}
