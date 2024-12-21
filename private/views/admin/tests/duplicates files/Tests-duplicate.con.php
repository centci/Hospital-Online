<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Tests controller
 */
class Tests extends Controller
{
  // Tests in the database
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
    }

    $test = New Test();
    $errors = [];
    // view all saved Tests in the database
    $Rows = $test->findAll();
    // show($Rows);die;

    require $this->viewsPath("admin/Tests/tests");
  }

  //add Tests to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }

    $test = New Test();
    $xtratest = New ExtraTest();
    $labSec = New LabSection();
    $samples = New Sample();
    $containers = New Container();
    $units = New Unit();

    $lab = $labSec->findAll();
    $sample = $samples->findAll();
    $container = $containers->findAll();
    $unit = $units->findAll();

    // getting the content of files from javascript
    $row_data = file_get_contents("php://input");

    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
    if (isset($_POST['toggleswitch']))
    {
      $_POST['xtraTestCode'] = $_POST['testname']."-".random_string(10);
      unset($_POST['refRanges']);
    }
    if (!isset($_POST['toggleswitch']))
    {
      unset($_POST['xtraTestCode']);
    }
    // if ($OBJ['data_type'] == "saveingTest")
    // {
    //   // show($OBJ);die;
    //
    //   $unit = $units->findAll();
    //
    //   if ($unit)
    //   {
    //     $info['data_type'] = 'savingXtraTest';
    //     $info['data'] = $unit;
    //     // echo json_encode($info);
    //   }
    //
    // }
    // echo json_encode($info);

    // validating of forms
    if ($test->validate($_POST))
    {
      $_POST['userId'] = Auth::getId();
      $_POST['testDate'] = date('Y-m-d H:i:s');
      $_POST['xtraUserId'] = Auth::getId();
      $_POST['xtraTestDate'] = date('Y-m-d H:i:s');

      // INSERT INTO GENERAL TEST TABLE
      $test->insert($_POST);

      // INSERT INTO EXTRA TEXT TABLE
      if (isset($_POST['toggleswitch']))
      {
        $xtratest->insert($_POST);
      }
      // message('Tests Successfully Saved!');
      // $this->redirect("Tests");
    }

    //handle results for json
    if (empty($test->errors))
    {
      $arr['message'] = "Tests Successfully Saved!";
    }
    else
    {
      $arr['message'] = "Please correct these errors";
      $arr['errors'] = $test->errors;
    }
    echo json_encode($arr);
    //handle results for json end here

    // else
    // {
    //   // errors
    //   $errors = $test->errors;
    // }
    }
    require $this->viewsPath("admin/Tests/tests-add");
  }

  //Edit Tests in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }

    $errors = [];
    $test = New Test();
    $labSec = New LabSection();
    $samples = New Sample();
    $containers = New Container();
    $units = New Unit();
    $xtratest = New ExtraTest();

    $lab = $labSec->findAll();
    $sample = $samples->findAll();
    $container = $containers->findAll();
    $unit = $units->findAll();
    $tests = $test->first('id',$id);
    $testxtra = $xtratest->first('xtraTestCode',$tests->xtraTestCode);

// show($testxtra );die;
// $row_data = file_get_contents("php://input");

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      // show($row_data );die;

      if (isset($_POST['toggleswitch']))
      {
        // unset($_POST['toggleswitch']);
        unset($_POST['refRanges']);
        unset($_POST['unitid']);
      }

// show($_POST);die;

      if ($test->validate($_POST))
      {
        // UPDATE GENERAL TEST TABLE
        $test->update($id,$_POST);
        // UPDATE EXTRA TEXT TABLE
        if (isset($_POST['toggleswitch']))
        {
          $xtratest->update($testxtra->id,$_POST);
        }
        message('Test Edited Successfully!');
        $this->redirect("Tests");
      }
      else
      {
        // errors
        $errors = $test->errors;
      }
    }
    require $this->viewsPath("admin/Tests/tests-edit");
  }
  //Delete Tests in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }
    $errors = [];
    $test = New Test();
    $row = $test->first('id',$id);

    $test->delete($id);
    message('Test Deleted Successfully!');
    $this->redirect("Tests");

    require $this->viewsPath("admin/Tests/tests");
  }
}
