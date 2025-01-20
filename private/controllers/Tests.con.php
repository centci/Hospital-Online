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

    $test = new Test();
    $errors = [];
    // view all saved Tests in the database
    $viewAllSavedTests = $test->findAll();
    // show($Rows);die;
    require $this->viewsPath("admin/Tests/tests");
  }

  //add Tests to the database
  public function add($id = null)
  {
    if (!Auth::logged_in())
    {
      warrningMessage('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }
    $errors = [];
    $test = new Test();
    $labSec = new LabSection();
    $samples = new Sample();
    $containers = new Container();
    $units = new Unit();

    $lab = $labSec->findAll();
    $sample = $samples->findAll();
    $container = $containers->findAll();
    $unit = $units->findAll();

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if (isset($_POST['toggleswitch']))
      {
        unset($_POST['unitid']);
        unset($_POST['refRanges']);
      }

      // validating of forms
      if ($test->validate($_POST))
      {

        $_POST['testsUserId'] = Auth::getUserId();
        $_POST['testDate'] = date('Y-m-d H:i:s');

        // INSERT INTO GENERAL TEST TABLE
        $test->insert($_POST);

        if (isset($_POST['toggleswitch']))
        {
          message('Please Add Sub-Tests!');

          $this->redirect("Tests/addExtraTests");
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
      warrningMessage('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }
    $test = new Test();
    $units = new Unit();
    $db = new Database();
    $unit = $units->findAll();

    // make sub Test Code
    $testCode['testCode']  = 'LAB'."0001";
    $TestCode = make_subTestCode($testCode);

    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

      if(!empty($_POST['data_type']) && $_POST['data_type'] == "save")
      {
        // validating of forms
        if ($test->validate($_POST))
        {
          $xtraTest = [];
          foreach ($_POST as $key => $value)
          {
        // Removing all the input under score and numbers at the end of each names
            if(!empty($value) && preg_match("/^[xtraTestName]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraRefRanges]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraUnitid]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraTestCode]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraUserId]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraTestDate]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[subTestCode]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
        // End of Removing all the input under score and numbers at the end of each names
          }
          // show($xtraTest);die;

          // =======Looping All The Arrays Of The Input Names To Insert Into Database=============
          $num = 1; //to add numbers to $xtraTest['subTestCode'];
          for ($i=0; $i < count ($xtraTest['xtraTestName']); $i++)
          {
            $subTestCode    =  $xtraTest['subTestCode'][$i].'-'.$num; //add - $num to $subTestCode;
            $xtraTestName   =  $xtraTest['xtraTestName'][$i];
            $xtraRefRanges  =  $xtraTest['xtraRefRanges'][$i];
            $xtraUnitid     =  $xtraTest['xtraUnitid'][$i];
            $xtraTestCode   =  $xtraTest['xtraTestCode'][$i];
            $xtraUserId     =  $xtraTest['xtraUserId'][$i];
            $xtraTestDate   =  $xtraTest['xtraTestDate'][$i];

            // increment subTestCode
            $num++;

            // insert statements for extar tests
            $sql = ("INSERT INTO `extratests` (`subTestCode`, `xtraTestName`, `xtraRefRanges`, `xtraUnitid`, `xtraTestCode`, `xtraUserId`, `xtraTestDate`) VALUES ('$subTestCode','$xtraTestName', '$xtraRefRanges', '$xtraUnitid', '$xtraTestCode', '$xtraUserId', '$xtraTestDate');");

            $results = $db->query($sql);
          }
          // ======End Of Looping All The Arrays Of The Input Names To Insert Into Database=============
          $info['data'] = 'extra test saved Successfully!';
          $info['data_type'] = "save";
        }else
        {
          $info['errors'] = $test->errors;
          $info['data'] = "please fix the erros on the page";
          $info['data_type'] = "save";
        }
        echo json_encode($info);
      }
      die();
    }
    require $this->viewsPath("admin/Tests/tests-add-extra");
  }

  //Edit Tests in the database
  public function edit($id = null)
  {
    if (!Auth::logged_in())
    {
      warrningMessage('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }

    $errors = [];
    $test = new Test();
    $labSec = new LabSection();
    $samples = new Sample();
    $containers = new Container();
    $units = new Unit();
    $extratest = new ExtraTest();
    $db = new Database();

    $lab = $labSec->findAll();
    $sample = $samples->findAll();
    $container = $containers->findAll();
    $unit = $units->findAll();
    $tests = $test->first('id',$id);

    // retriving extraTest for editing
    $query = "SELECT subTestCode FROM extratests WHERE xtraTestCode = '$tests->testCode' ORDER BY subTestCode DESC LIMIT 1";
    $results = $db->query($query);
    if ($results) {
      // code...
      $lastSubTestCode = $results[0]->subTestCode;
    }

    $testxtra = $extratest->where('xtraTestCode',$tests->testCode);
    // show($testxtra);die;

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if(!empty($_POST['data_type']) && $_POST['data_type'] == "save")
      {
        if (isset($_POST['toggleswitch']) && !empty($_POST['toggleswitch']))
        {
          unset($_POST['refRanges']);
          unset($_POST['unitid']);
        }

        // validating of forms
        if ($test->validate($_POST))
        {
          // UPDATE GENERAL TEST TABLE
          $test->update($id,$_POST);

        // UPDATE EXTRA TEST TABLE
        if (isset($_POST['toggleswitch']) && !empty($_POST['toggleswitch']))
        {
          $xtraTest = [];
          foreach ($_POST as $key => $value)
          {
        // Removing all the input under score and numbers at the end of each names
            if(!empty($value) && preg_match("/^[xtraTestName]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }else
            if(!empty($value) && preg_match("/^[xtraRefRanges]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }else
            if(!empty($value) && preg_match("/^[xtraUnitid]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }else
            if(!empty($value) && preg_match("/^[id]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
        // End of Removing all the input under score and numbers at the end of each names
          }

        // ===============Looping All The Arrays Of The Input Names To Insert Into Database=============
          for ($i=0; $i < count ($xtraTest['xtraTestName']); $i++)
          {
            $xtraTestName   =  $xtraTest['xtraTestName'][$i];
            $xtraRefRanges  =  $xtraTest['xtraRefRanges'][$i];
            $xtraUnitid     =  $xtraTest['xtraUnitid'][$i];
            $id             =  $xtraTest['id'][$i];

          // update statements for extar tests
            $sql = ("UPDATE extratests SET xtraTestName = '$xtraTestName', xtraRefRanges = '$xtraRefRanges', xtraUnitid = '$xtraUnitid' WHERE id = '$id'");
            $results = $db->query($sql);
          }
        // ============End Of Looping All The Arrays Of The Input Names To Insert Into Database==========
        }
          $info['data'] = 'Test Edited Successfully!';
          $info['data_type'] = "save";
        }else
        {
          $info['errors'] = $test->errors;
          $info['data'] = "please fix the erros on the page";
          $info['data_type'] = "save";
        }
        echo json_encode($info);
      }
      die();
    }
    require $this->viewsPath("admin/Tests/tests-edit");
  }
  // editing and adding more tests row to xtratest table
  public function edit_xtratest_add($lastSubTestCode = null)
  {
    if (!Auth::logged_in())
    {
      warrningMessage('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }

    $units = new Unit();
    $extratest = new ExtraTest();
    $test = new Test();
    $db = new Database();

    // extracting tests units
    $unit = $units->findAll();
    //endz of extracting tests units

    // EXTRACTING EXTRATESTCODE FROM THE LAST SUBTESTCODE

      // initialization of the lastSubTestCode
      $lastSubTest = $lastSubTestCode;

      // the strrpos function search for the last occurance of hypen in the string
      $position = strrpos($lastSubTest, '-');

      // we check if the $position is not equal to false. if its not false,
      //it means the hpypen exist in the string.
      //use the substr($lastSubTest,0,$position) extract the charct from position 0 up to (but not incuding)
      // the position of the last hypen.
      if ($position !== false) {$xtraTestCode = substr($lastSubTest,0,$position); }

    //ENDZ OF EXTRACTING EXTRATESTCODE FROM THE LAST SUBTESTCODE

    // extracting full list of tests that corespond to the extraTestCode
    $testxtra = $extratest->where('xtraTestCode',$xtraTestCode);
    //endz of extracting full list of tests that corespond to the extraTestCode

    // server request
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
      if(!empty($_POST['data_type']) && $_POST['data_type'] == "save")
      {
        // validating of forms
        if ($test->validate($_POST))
        {
          $xtraTest = [];
          foreach ($_POST as $key => $value)
          {
        // Removing all the input under score and numbers at the end of each names
            if(!empty($value) && preg_match("/^[xtraTestName]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraRefRanges]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraUnitid]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraTestCode]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraUserId]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[xtraTestDate]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[subTestCode]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
        // End of Removing all the input under score and numbers at the end of each names
          }
          // =======Looping All The Arrays Of The Input Names To Insert Into Database=============
          for ($i=0; $i < count ($xtraTest['xtraTestName']); $i++)
          {
            $subTestCode    =  $xtraTest['subTestCode'][$i];
            $xtraTestName   =  $xtraTest['xtraTestName'][$i];
            $xtraRefRanges  =  $xtraTest['xtraRefRanges'][$i];
            $xtraUnitid     =  $xtraTest['xtraUnitid'][$i];
            $xtraTestCode   =  $xtraTest['xtraTestCode'][$i];
            $xtraUserId     =  $xtraTest['xtraUserId'][$i];
            $xtraTestDate   =  $xtraTest['xtraTestDate'][$i];

            // insert statements for extar tests
            $sql = ("INSERT INTO `extratests` (`subTestCode`, `xtraTestName`, `xtraRefRanges`, `xtraUnitid`, `xtraTestCode`, `xtraUserId`, `xtraTestDate`) VALUES ('$subTestCode','$xtraTestName', '$xtraRefRanges', '$xtraUnitid', '$xtraTestCode', '$xtraUserId', '$xtraTestDate');");

            $results = $db->query($sql);
          }
          // ======End Of Looping All The Arrays Of The Input Names To Insert Into Database=============
          $info['data'] = 'extra test saved Successfully!';
          $info['data_type'] = "save";
        }else
        {
          $info['errors'] = $test->errors;
          $info['data'] = "please fix the erros on the page";
          $info['data_type'] = "save";
        }
        echo json_encode($info);
      }
      die();
    }
    require $this->viewsPath("admin/Tests/tests-edit-add");
  }
  // editing and adding more tests row to xtratest table endz

  //Delete Tests in the database
  public function delete($id = null)
  {
    if (!Auth::logged_in())
    {
      warrningMessage('You Must Be An Admin To Access This Page!');
      $this->redirect('login');
    }
    $errors = [];
    $test = new Test();
    $row = $test->first('id',$id);

    $test->delete($id);
    message('Test Deleted Successfully!');
    $this->redirect("Tests");

    require $this->viewsPath("admin/Tests/tests");
  }
  //Delete Tests in the database endz

}
