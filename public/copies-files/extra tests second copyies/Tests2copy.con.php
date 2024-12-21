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
    $labSec = New LabSection();
    $samples = New Sample();
    $containers = New Container();
    $units = New Unit();

    $lab = $labSec->findAll();
    $sample = $samples->findAll();
    $container = $containers->findAll();
    $unit = $units->findAll();

    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if (isset($_POST['toggleswitch']))
      {
      $xtraTestCode  = $_POST['xtraTestCode'] = $_POST['testname']."-".random_string(10);
        unset($_POST['unitid']);
        unset($_POST['refRanges']);
      }
      // show($_POST);die;
      // validating of forms
      if ($test->validate($_POST))
      {
        $_POST['userId'] = Auth::getId();
        $_POST['testDate'] = date('Y-m-d H:i:s');

        // we lower the extraTest id incase the user typed in uppercase
        $xtraTestCode = strtolower($xtraTestCode);

        // INSERT INTO GENERAL TEST TABLE
        $test->insert($_POST);

        if (isset($_POST['toggleswitch']))
        {
          message('Please Add Extra Tests!');

          warrningMessage('Please make sure you add all row needed before you start entering your data, or if you find out you need more row as you typing, first submit the one you entered, other rows you will add after, otherwise you will loose all the data if you clik ADD more row when you are typing');

          $this->redirect("Tests/addExtraTests/".$xtraTestCode);
        }
        message('Tests Successfully Saved!');
        $this->redirect("Tests");
      }
      else
      {
        // errors
        $errors = $test->errors;
      }
    }

    require $this->viewsPath("admin/Tests/tests-add");
  }
  //add extra Tests to the database
  public function addExtraTests($id = null)
  {
    if (!Auth::logged_in())
    {
      message('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }
    $xtratest = New ExtraTest();
    $units = New Unit();
    $unit = $units->findAll();

    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      $xtraTestCode = $_POST['xtraTestCode'] = $id;
      $_POST['xtraUserId'] = Auth::getId();
      $_POST['xtraTestDate'] = date('Y-m-d H:i:s');
      // we lower the extraTest id incase the user typed in uppercase
      $xtraTestCode = strtolower($xtraTestCode);

show($_POST);die;

      // validating of forms
      if ($xtratest->validate($_POST))
      {
        if (is_array($_POST))
        {
          $xtraTestName_num = 0;
          $xtraRefRanges_num = 0;
          $xtraUnitid_num = 0;

          // show($_POST);die;

          foreach ($_POST as $key => $value)
          {
            // show($key);die;
            $Arr = [];
            if (strstr($key, 'xtraTestName'))
            {
              $Arr['xtraTestName'.$xtraTestName_num] = $value;
              $xtraTestName_num++;
            }

            if (strstr($key, 'xtraRefRanges'))
            {
              $Arr['xtraRefRanges'.$xtraRefRanges_num ] = $value;
              $xtraRefRanges_num++;
            }
            if (strstr($key, 'xtraUnitid'))
            {
              $Arr['xtraUnitid'.$xtraUnitid_num] = $value;
              $xtraUnitid_num++;
            }
            show($Arr);die;

          // $testArr = [];
          // $testArr['itemCode'] = $row['testCode'];
          // $testArr['pendingPayId'] = $receipt_no;
          // $testArr['patientNo'] = $ptnInfo->patientId;
          // $testArr['departmentId'] = $row['departmentId'];
          // $testArr['sentBy'] = $loggedinUser;
          // $testArr['pendingPayDate'] = $dateRecorded;
          // $pendingpayment->insert($testArr);
          }
        }
        // INSERT INTO EXTRA TEXT TABLE
        // $xtratest->insert($_POST);
        message('Extra Tests Successfully Saved!');
        $this->redirect("Tests/addExtraTests/".$xtraTestCode);
      }
      else
      {
        // show($xtratest->errors);die;
        // errors
        $errors = $xtratest->errors;
      }
    }

    require $this->viewsPath("admin/Tests/tests-add-extra");
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

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if (isset($_POST['toggleswitch']))
      {
        // unset($_POST['toggleswitch']);
        unset($_POST['refRanges']);
        unset($_POST['unitid']);
      }

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
