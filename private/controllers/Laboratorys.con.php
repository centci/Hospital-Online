<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');
/**
 * Patients controller
 */
class Laboratorys extends Controller
{
  // dispaly Patients Laboratory new and old Request
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      warrningMessage('Please Login To Access This Page!');

      $this->redirect('login');
    }
    $testdetails = New cashierSaved();

    // code...
    if (isset($_GET['Request_New']))
    {
      // here we are to use JOIN to SELECT record that match from different tables of tests, pendingPayments, patients and department
      $requestItems = $testdetails->query("SELECT patientNo, itemCode, testCode, testname, cost, pymt_status, firstname, lastname, department, cashierSavedReceiptNo, cashierSavedBy, cashierSavedDate FROM `cashierSaveds`
        JOIN tests ON cashierSaveds.cashierSavedTestCode = tests.testCode
        JOIN pendingPayments ON cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
        JOIN patients ON pendingPayments.patientNo = patients.patientId
        JOIN departments ON pendingPayments.departmentId = departments.dept_id
        WHERE cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
        AND cashierSaveds.cashierSavedTestCode = pendingPayments.itemCode
        AND cashierSaveds.cashierSavedStatus = 'not saved'
        AND PendingPayments.pymt_status = 'paid' ");
        $rows = $requestItems;
      }else
      if (isset($_GET['Request_Old']))
      {
      // here we are to use JOIN to SELECT record that match from different tables of tests, pendingPayments, patients and department
      $requestItems = $testdetails->query("SELECT patientNo, itemCode, testCode, testname, cost, pymt_status, firstname, lastname, department, cashierSavedReceiptNo, cashierSavedBy, cashierSavedDate FROM `cashierSaveds`
        JOIN tests ON cashierSaveds.cashierSavedTestCode = tests.testCode
        JOIN pendingPayments ON cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
        JOIN patients ON pendingPayments.patientNo = patients.patientId
        JOIN departments ON pendingPayments.departmentId = departments.dept_id
        WHERE cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId AND cashierSaveds.cashierSavedTestCode = pendingPayments.itemCode AND PendingPayments.pymt_status = 'not paid'");
        $rows = $requestItems;
      }

    require $this->viewsPath("laboratory/laboratory");
  }

// function for displaying laboratory new and old request details
public function displayItemDetails($cashierSavedReceiptNo=null)
{
  if (!Auth::logged_in())
  {
    warrningMessage('Please Login To Access This Page!');
    $this->redirect('login');
  }

  $itemDetail = New DataBase();
  // get content from php
  $row_data = file_get_contents("php://input");

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if (!empty($row_data))
    {
      $OBJ = json_decode($row_data,true);
      if (is_array($OBJ))
      {
        if ($OBJ['data_type'] == "requestDetails")
        {
          $LabItemsToSave = $itemDetail->query("SELECT testname, testCode, cost, pymt_status, firstname, lastname, patientId, cashierSavedReceiptNo, cashierSavedBy, cashierSavedDate FROM `cashierSaveds`
            JOIN tests ON cashierSaveds.cashierSavedTestCode = tests.testCode
            JOIN pendingPayments ON cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
            JOIN patients ON pendingPayments.patientNo = patients.patientId
            WHERE cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
            AND cashierSaveds.cashierSavedTestCode = pendingPayments.itemCode
            AND cashierSaveds.cashierSavedReceiptNo = '$cashierSavedReceiptNo'
            AND cashierSaveds.cashierSavedStatus = 'not saved'

            AND PendingPayments.pymt_status = 'paid'");

          if ($LabItemsToSave)
          {
            $info['data_type'] = 'LabitemDetail';
            $info['data'] = $LabItemsToSave;
            echo json_encode($info);
          }
        }
        else if ($OBJ['data_type'] == "submit_lab_item")
        {
          $savingLabRequest = New LabRequest();
          $db = New DataBase();

          $itemsData = $OBJ['text'];
          $labReqSampleId = random_string(10);
          $loggedinUser = $_POST['userId'] = Auth::getId();
          $dateRecorded = $_POST['DrawnDate'] = date('Y-m-d H:i:s');

          if (is_array($itemsData))
          {
            foreach ($itemsData as $row)
            {
            $itemArr = [];
            $itemArr['labReqSampleId'] = $labReqSampleId;
            $itemArr['labReqPtn_id'] = $row['patientId'];
            $itemArr['labReqTestCode'] = $row['testCode'];
            $itemArr['LabReqFinaceReceipt'] = $row['cashierSavedReceiptNo'];
            $itemArr['labReqSaved_by'] = $loggedinUser;
            $itemArr['DrawnDate'] = $dateRecorded;

            $savedItems = $savingLabRequest->insert($itemArr);

          // UPDATING CASHIERSAVEDS TABLE AT THE SAME TIME AFTER INSERTING TO LABREQUEST TABLE
            $itemCode         =   $itemArr['labReqTestCode']      = $row['testCode'];
            $FinaceReceiptNo  =   $itemArr['LabReqFinaceReceipt'] = $row['cashierSavedReceiptNo'];

            $query = "UPDATE cashierSaveds SET cashierSavedStatus = 'saved' WHERE cashierSavedTestCode = :cashierSavedTestCode AND cashierSavedReceiptNo = :cashierSavedReceiptNo";
            $ptnInfo = $db->query($query,['cashierSavedTestCode'=>$itemCode, 'cashierSavedReceiptNo'=>$FinaceReceiptNo]);
            }
          }
            $info['data_type'] = 'submit_items';
            $info['data'] = "saved saccessfully";
            echo json_encode($info);
        }
      }
    }
    die();
   }
  require $this->viewsPath("laboratory/laboratory-item-details");
}

// saved laboratory Requests
public function Laboratorysavedrequest()
{
  if (!Auth::logged_in())
  {
    warrningMessage('Please Login To Access This Page!');
    $this->redirect('login');
  }

  $saveLabRequest = New LabRequest();

  $rows = $saveLabRequest->query("SELECT patientId, firstname, lastname, testCode, cost, testname, labReqSampleId, DrawnDate  FROM `labRequests`
  JOIN tests on labRequests.labReqTestCode = tests.testCode
  JOIN patients on labRequests.labReqPtn_id = patients.patientId WHERE labRequests.labReqStatus = 'NotReported'");

  require $this->viewsPath("laboratory/laboratory-saved-request");
}
// saved laboratory Requests details
public function LaboratorysavedrequestDetails_submitReport($patientId=null,$labReqSampleId=null)
{
  if (!Auth::logged_in())
  {
    warrningMessage('Please Login To Access This Page!');
    $this->redirect('login');
  }

  $db = New DataBase();
  $saveLabRequest = New Test();
  $patientInfo    = New Patient();
  $labReport      = New LabReport();

  $row = $patientInfo->first('patientId',$patientId);

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    // show($_POST);die;
    if(!empty($_POST['data_type']) && $_POST['data_type'] == "labtests")
    {
      $saveLabRequestRow = [];
      $saveLabRequestRow = $saveLabRequest->query("SELECT * FROM labRequests
      JOIN tests ON labRequests.labReqTestCode = tests.testCode
      WHERE labRequests.labReqSampleId = $labReqSampleId AND labRequests.labReqStatus = 'NotReported'");
      if ($saveLabRequestRow)
      {
        $info['data_type'] = 'labtests';
        $info['data'] = $saveLabRequestRow;

        echo json_encode($info);
      }
    }else
    if (!empty($_POST['data_type']) && $_POST['data_type'] == "xtralabtests")
    {
      $extralabtest_id = $_POST['extraTest_id'];
      if (!empty($extralabtest_id))
      {
        $extraLabTestRow = [];
        $extraLabTestRow = $saveLabRequest->query("SELECT * FROM tests
        JOIN extratests ON tests.testCode = extratests.xtraTestCode
        JOIN units ON extratests.xtraUnitid = units.unit_id
        WHERE extratests.xtraTestCode  = '$extralabtest_id'");

        if ($extraLabTestRow)
        {
          $info['data_type'] = 'xtralabtests';
          $info['data'] = $extraLabTestRow;

          echo json_encode($info);
        }
      }
    }
    else
    //INSERT TEST RESULTS TO REPORT TABLE
    if (!empty($_POST) && $_POST['data_type'] == "save")
    {
      if (isset($_POST['extratestResults_0']))
      {
        unset($_POST['testResult']);
        unset($_POST['unitname']);
        unset($_POST['reportLabReqSampleId']);
        unset($_POST['reportTestCode']);
        unset($_POST['labReportId']);
        unset($_POST['reportUserId']);
        unset($_POST['reportDate']);
      }

      // validating of forms
      if ($labReport->validate($_POST))
      {
        // INSERT INTO TEST REPORT TABLE
        $xtraTest = [];
        if (isset($_POST['testResult']))
        {
          // insert single test to reports Db.
          $labReport->insert($_POST);

          $labReqTestCode = $_POST['reportTestCode'];

          // UPDATING LAB REQUEST TABLE SET STATUS TO Reported FOR SINGLE TEST, AFTER INSERTING TO LABREPORT TABLE
          $query = "UPDATE labRequests SET labReqStatus = 'Reported' WHERE labReqSampleId = :labReqSampleId AND labReqTestCode = :labReqTestCode";
          $ptnInfo = $db->query($query,['labReqSampleId'=>$labReqSampleId, 'labReqTestCode'=>$labReqTestCode]);

          $info['data'] = 'Result saved Successfully!';
          $info['data_type'] = "save";
        }else
        {
          foreach ($_POST as $key => $value)
          {
        // Removing all the input under score and numbers at the end of each names
            if(!empty($value) && preg_match("/^[extratestResults]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[extraTestReportSampId]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[extraTestReportTestCode]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[extraTestReportSubTestCode]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[extraTestReportId]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[extraTestReportBy]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
            else
            if(!empty($value) && preg_match("/^[extraTestReportDate]+_[0-9]+$/", $key))
            {
              $mainkey = RemoveSpecialChar($key);
              $xtraTest[$mainkey][] = $value;
            }
        // End of Removing all the input under score and numbers at the end of each names
          }
    // ===============Looping All The Arrays Of The Input Names To Insert Into Database=============
          for ($i=0; $i < count ($xtraTest['extratestResults']); $i++)
          {
            $extraTestReportId            =   $xtraTest['extraTestReportId'][$i];
            $extraTestReportSampId        =   $xtraTest['extraTestReportSampId'][$i];
            $extratestResults             =   $xtraTest['extratestResults'][$i];
            $extraTestReportTestCode      =   $xtraTest['extraTestReportTestCode'][$i];
            $extraTestReportSubTestCode   =   $xtraTest['extraTestReportSubTestCode'][$i];
            $extraTestReportBy            =   $xtraTest['extraTestReportBy'][$i];
            $extraTestReportDate          =   $xtraTest['extraTestReportDate'][$i];

            // insert statements for extar tests
            $sql =  ("INSERT INTO `labextratestreports`(`extraTestReportId`, `extraTestReportSampId`, `extratestResults`, `extraTestReportTestCode`, `extraTestReportSubTestCode`, `extraTestReportBy`, `extraTestReportDate`) VALUES ('$extraTestReportId', '$extraTestReportSampId', '$extratestResults', '$extraTestReportTestCode', '$extraTestReportSubTestCode', '$extraTestReportBy', '$extraTestReportDate')");
            $results = $db->query($sql);

            // UPDATING LAB REQUEST TABLE SET STATUS TO Reported FOR EXTRA TEST, AFTER INSERTING TO LABREPORT TABLE
            $query = "UPDATE labRequests SET labReqStatus = 'Reported' WHERE labReqSampleId = :labReqSampleId AND labReqTestCode = :labReqTestCode";
            $updatelabrequests = $db->query($query,['labReqSampleId'=>$extraTestReportSampId, 'labReqTestCode'=>$extraTestReportTestCode ]);
          }
    // ===============End Of Looping All The Arrays Of The Input Names To Insert Into Database=============
        }
        $info['data'] = 'Result saved Successfully!';
        $info['data_type'] = "save";
      }else
      {
        $info['errors'] = $labReport->errors;
        $info['data'] = "please fix the erros on the page";
        $info['data_type'] = "save";
      }
      echo json_encode($info);
    }
    die();
  }
  require $this->viewsPath("laboratory/laboratory-saved-request-details");
}

public function laboratoryreports($id='')
{
  if (!Auth::logged_in())
  {
    warrningMessage('Please Login To Access This Page!');

    $this->redirect('login');
  }

  $labReport      = New LabReport();

  $labReportRows = $labReport->query("SELECT DISTINCT patients.patientId, patients.firstname, patients.middlename, patients.lastname,  patients.gender, patients.phone,patients.country, Date(labReports.reportDate) AS reportDate, users.firstname AS userFirst, users.lastname AS userLast, labRequests.labReqSampleId FROM `labReports`
    JOIN labRequests ON labRequests.labReqSampleId = labReports.reportLabReqSampleId
    JOIN patients ON labRequests.labReqPtn_id = patients.patientId
    JOIN users ON labReports.reportUserId = users.id;");

  require $this->viewsPath("laboratory/laboratory-reports");
}
public function laboratoryreportsdetails($patientId='',$labReqSampleId='')
{
  if (!Auth::logged_in())
  {
    warrningMessage('Please Login To Access This Page!');

    $this->redirect('login');
  }

  $labReport      = New Test();
  $patientInfo    = New Patient();
;
  $patientInfoRow = $patientInfo->first('patientId',$patientId);

// show($patientInfoRow);die;

  $labReportRows = $labReport->query("SELECT * FROM `labReports` JOIN tests ON tests.testCode = labReports.reportTestCode WHERE labReports.reportLabReqSampleId = '$labReqSampleId'");

// show($labReportRows);die;
  require $this->viewsPath("laboratory/laboratory-reports-details");
}

// SELECT * FROM labRequests
// JOIN patients ON labRequests.labReqPtn_id = patients.patientId
// JOIN cashierSaveds ON labRequests.LabReqFinaceReceipt = cashierSaveds.cashierSavedReceiptNo
// JOIN pendingPayments ON cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId

}
