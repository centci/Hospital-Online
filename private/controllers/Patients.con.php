<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');
/**
 * Patients controller
 */
class Patients extends Controller
{
  // dispaly Patients information from database
  public function index($id = null)
  {
    if (!Auth::logged_in()) {
      $this->redirect('login');
    }
    $patient = new Patient();
    $ptn = $patient->findAll();

    require $this->viewsPath("patients/patients");
  }
// register patient persional information into Database
  public function add($id = null)
  {
    $errors = [];
    if (!Auth::logged_in()) {
      $this->redirect('login');
    }
    $patient = new Patient();

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($patient->validate($_POST))
      {
        $_POST['userId'] = Auth::getUserId();
        $_POST['date'] = date('Y-m-d H:i:s');

        $patient->insert($_POST);
        $this->redirect('patients/patients');
      }
      else
      { // handle errors
        $errors = $patient->errors;
      }
    }

    require $this->viewsPath("patients/patients-add");
  }
  // edit patients personal information
  public function edit($id = null)
  {
    $errors = [];
    if (!Auth::logged_in()) {
      $this->redirect('login');
    }
    $patient = new Patient();
    $row = $patient->first('id',$id);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if ($patient->validate($_POST))
      {
        $patient->update($id,$_POST);
        $this->redirect('patients/patients');
      }
      else
      { // handle errors
        $errors = $patient->errors;
      }
    }
    require $this->viewsPath("patients/patients-edit");
  }
  // patients personal informations
  public function details($id = null)
  {
    if (!Auth::logged_in()) {
      $this->redirect('login');
    }

    $patient = new Patient();
    $row = $patient->first('id',$id);
    // show($row);die;

    require $this->viewsPath("patients/patients-details-view");
  }

}
