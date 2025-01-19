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
    $testdetails = new cashierSaved();

    // code...
    if (isset($_GET['Request_New']))
    {
      // here we are to use JOIN to SELECT record that match from different tables of tests, pendingPayments, patients and department
      $requestItems = $testdetails->query("SELECT patientNo, itemCode, testCode, testname, cost, pymt_status, firstname, lastname, department, cashierSavedReceiptNo, cashierSavedBy, cashierSavedDate FROM `cashierSaveds`
        JOIN tests ON cashierSaveds.cashierSavedTestCode = tests.testCode
        JOIN pendingPayments ON cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
        JOIN patients ON pendingPayments.patientNo = patients.patientId
        JOIN departments ON pendingPayments.departmentId = departments.deptId
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
        JOIN departments ON pendingPayments.departmentId = departments.deptId
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

  $itemDetail = new DataBase();
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
          $savingLabRequest = new LabRequest();
          $db = new DataBase();

          $itemsData = $OBJ['text'];
          $labReqSampleId = random_string(10);
          $loggedinUser = $_POST['userId'] = Auth::getUserId();
          $dateRecorded = $_POST['DrawnDate'] = date('Y-m-d H:i:s');

          if (is_array($itemsData))
          {
            foreach ($itemsData as $row)
            {
            $itemArr = [];
            $itemArr['labReqSampleId'] = $labReqSampleId;
            $itemArr['labReqPatientId'] = $row['patientId'];
            $itemArr['labReqTestCode'] = $row['testCode'];
            $itemArr['LabReqCashierSavedReceiptNo'] = $row['cashierSavedReceiptNo'];
            $itemArr['labReqSavedByUserId'] = $loggedinUser;
            $itemArr['DrawnDate'] = $dateRecorded;

            $savedItems = $savingLabRequest->insert($itemArr);

          // UPDATING CASHIERSAVEDS TABLE AT THE SAME TIME AFTER INSERTING TO LABREQUEST TABLE
            $itemCode         =   $itemArr['labReqTestCode']      = $row['testCode'];
            $FinaceReceiptNo  =   $itemArr['LabReqCashierSavedReceiptNo'] = $row['cashierSavedReceiptNo'];

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

  $saveLabRequest = new LabRequest();

  $rows = $saveLabRequest->query("SELECT patientId, firstname, lastname, testCode, cost, testname, labReqSampleId, DrawnDate  FROM `labRequests`
  JOIN tests on labRequests.labReqTestCode = tests.testCode
  JOIN patients on labRequests.labReqPatientId = patients.patientId WHERE labRequests.labReqStatus = 'NotReported'");

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

  $db = new DataBase();
  $saveLabRequest = new Test();
  $patientInfo    = new Patient();
  $labReport      = new LabReport();

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
        JOIN units ON extratests.xtraUnitid = units.unitId
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
      // if (isset($_POST['extratestResults_0']))
      // {
      //   unset($_POST['testResult']);
      //   unset($_POST['unitname']);
      //   unset($_POST['reportLabReqSampleId']);
      //   unset($_POST['reportTestCode']);
      //   unset($_POST['labReportId']);
      //   unset($_POST['reportUserId']);
      //   unset($_POST['reportDate']);
      // }

      if (isset($_POST['extratestResults_0']))
      {
        // Unset all variables starting with "testResult", "unitname", etc.
        foreach (['testResult', 'unitname', 'reportLabReqSampleId', 'reportTestCode', 'labReportId', 'reportUserId', 'reportDate'] as $key) {
            unset($_POST[$key]);
        }
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

  $labReport      = new LabReport();

  $labReportRows = $labReport->query("SELECT DISTINCT patients.patientId, patients.firstname, patients.middlename, patients.lastname,  patients.gender, patients.phone,patients.country, Date(labReports.reportDate) AS reportDate, users.firstname AS userFirst, users.lastname AS userLast, labRequests.labReqSampleId FROM `labReports`
    JOIN labRequests ON labRequests.labReqSampleId = labReports.reportLabReqSampleId
    JOIN patients ON labRequests.labReqPatientId = patients.patientId
    JOIN users ON labReports.reportUserId = users.id;");

  require $this->viewsPath("laboratory/laboratory-reports");
}
// public function laboratoryreportsdetails($patientId='',$labReqSampleId='')
// {
//   if (!Auth::logged_in())
//   {
//     warrningMessage('Please Login To Access This Page!');
//
//     $this->redirect('login');
//   }
//
//   $labReport      = new Test();
//   $patientInfo    = new Patient();
//
// // getting patients information to print patients results or reports
//   $patientInfoRow = $patientInfo->query("SELECT DISTINCT
//   CONCAT(patients.firstname,' ',patients.middlename,' ',patients.lastname) AS PatientsFullName, patients.gender, patients.dob, patients.patientId, visits.visitCat, visits.VisitDate, visits.billMode, labRequests.labReqSampleId AS SpecimenNo, labRequests.DrawnDate, CONCAT(users.firstname, ' ', users.lastname) AS DrawnBy, visits.drUserId
//
//   FROM labRequests
//   JOIN patients ON labRequests.labReqPatientId = patients.patientId
//   JOIN cashierSaveds ON labRequests.LabReqCashierSavedReceiptNo = cashierSaveds.cashierSavedReceiptNo
//   JOIN visits ON labRequests.labReqVisitId = visits.visit_Id
//   JOIN users ON labRequests.labReqSavedByUserId = users.userId
//   WHERE labRequests.labReqSampleId = :labReqSampleId",
//   [':labReqSampleId' => $labReqSampleId]);
//
//   $patientInfo = $patientInfoRow[0];
//   // show($patientInfo);die;
//
// // getting results for single test from labReports table
// $labReportRows = $labReport->query("SELECT labReports.reportLabReqSampleId, tests.testname, labReports.testResult, tests.refRanges, tests.unitid
//    FROM `labReports`
//    JOIN tests ON tests.testCode = labReports.reportTestCode
//    WHERE labReports.reportLabReqSampleId = :labReqSampleId",
//   [':labReqSampleId' => $labReqSampleId]);
//
// // getting primary name of Extra Test From Tests Table
//   foreach ($labReportRows as $key => $primaryRow)
//   {
//     if ($primaryRow->reportLabReqSampleId)
//     {
//       $primaryTestName = $labReport->query("SELECT DISTINCT tests.testname  FROM `labextratestreports`
//       JOIN tests ON labextratestreports.extraTestReportTestCode = tests.testCode
//       WHERE labextratestreports.extraTestReportTestCode = tests.testCode AND labextratestreports.extraTestReportSampId  = '$labReqSampleId'");
//
//     }
//   }
// // getting result for extra tests from labextratestreports table
//   foreach ($labReportRows as $key => $labReportRow)
//   {
//     if ($labReportRow->reportLabReqSampleId)
//     {
//       $ExtralabReportRow = $labReport->query("
//         SELECT extratests.xtraTestName AS testname,
//                labextratestreports.extratestResults AS testResult,
//                extratests.xtraRefRanges AS refRanges,
//                extratests.xtraUnitid AS unitid
//         FROM labextratestreports
//         JOIN extratests
//               ON labextratestreports.extraTestReportSubTestCode = extratests.subTestCode
//         WHERE labextratestreports.extraTestReportSampId = :labReqSampleId", [':labReqSampleId' => $labReqSampleId]);
//     }
//   }
//
// $ReportRow = array_merge($labReportRows, $primaryTestName, $ExtralabReportRow);
//
// // show($ReportRow);die;
//   require $this->viewsPath("laboratory/laboratory-reports-details");
// }

// public function laboratoryreportsdetails($patientId = '', $labReqSampleId = '')
// {
//     // Ensure the user is logged in
//     if (!Auth::logged_in()) {
//         warrningMessage('Please Login To Access This Page!');
//         $this->redirect('login');
//     }
//
//     $labReport = new Test();
//     $patientInfo = new Patient();
//
//     // 1. Fetch patient information
//     $patientInfoRow = $patientInfo->query("
//         SELECT DISTINCT
//             CONCAT(patients.firstname, ' ', patients.middlename, ' ', patients.lastname) AS PatientsFullName,
//             patients.gender, patients.dob, patients.patientId,
//             visits.visitCat, visits.VisitDate, visits.billMode,
//             labRequests.labReqSampleId AS SpecimenNo, labRequests.DrawnDate,
//             CONCAT(users.firstname, ' ', users.lastname) AS DrawnBy, visits.drUserId
//         FROM labRequests
//         JOIN patients ON labRequests.labReqPatientId = patients.patientId
//         JOIN cashierSaveds ON labRequests.LabReqCashierSavedReceiptNo = cashierSaveds.cashierSavedReceiptNo
//         JOIN visits ON labRequests.labReqVisitId = visits.visit_Id
//         JOIN users ON labRequests.labReqSavedByUserId = users.userId
//         WHERE labRequests.labReqSampleId = :labReqSampleId",
//         [':labReqSampleId' => $labReqSampleId]
//     );
//
//     $patientInfo = $patientInfoRow[0];
//
//     // 2. Fetch primary and extra test results in a structured way
//     $combinedReportData = $labReport->query("
//         SELECT
//             tests.testname AS primaryTestName,                          -- Primary test (e.g., RFT)
//             extratests.xtraTestName AS subTestName,                     -- Subtest (e.g., Urea, Creatinine, etc.)
//             labReports.testResult AS primaryTestResult,                -- Result for the primary test
//             extratests.xtraRefRanges AS subTestRefRange,                -- Reference Range for the subtest
//             extratests.xtraUnitid AS subTestUnit,                       -- Units for the subtest
//             labextratestreports.extratestResults AS subTestResult       -- Result for the subtest
//         FROM labReports
//         JOIN tests ON labReports.reportTestCode = tests.testCode
//         LEFT JOIN labextratestreports
//             ON labReports.reportLabReqSampleId = labextratestreports.extraTestReportSampId
//         LEFT JOIN extratests
//             ON labextratestreports.extraTestReportSubTestCode = extratests.subTestCode
//         WHERE labReports.reportLabReqSampleId = :labReqSampleId",
//         [':labReqSampleId' => $labReqSampleId]
//     );
//
//     // 3. Group data by primary test name
//     $structuredReports = [];
//     foreach ($combinedReportData as $row) {
//         $primaryTestName = $row->primaryTestName;
//
//         // If primary test doesn't exist, initialize its structure
//         if (!isset($structuredReports[$primaryTestName])) {
//             $structuredReports[$primaryTestName] = [
//                 'primaryTestResult' => $row->primaryTestResult,
//                 'subtests' => [] // Initialize subtests array
//             ];
//         }
//
//         // Add subtest information if it exists
//         if ($row->subTestName) {
//             $structuredReports[$primaryTestName]['subtests'][] = [
//                 'name' => $row->subTestName,
//                 'result' => $row->subTestResult,
//                 'range' => $row->subTestRefRange,
//                 'unit' => $row->subTestUnit
//             ];
//         }
//     }
//
//     // 4. Prepare data to send to the view
//     $data = [
//         'patientInfo' => $patientInfo,
//         'structuredReports' => $structuredReports
//     ];
// show($data);die;
//     // 5. Load the view with structured data
//     require $this->viewsPath("laboratory/laboratory-reports-details", $data);
// }
public function laboratoryreportsdetails($patientId = '', $labReqSampleId = '')
{
    // Ensure the user is logged in
    if (!Auth::logged_in()) {
        warrningMessage('Please Login To Access This Page!');
        $this->redirect('login');
    }

    $labReport = new Test();
    $patientInfo = new Patient();

    // 1. Fetch patient information
    $patientInfoRow = $patientInfo->query("
        SELECT DISTINCT
            CONCAT(patients.firstname, ' ', patients.middlename, ' ', patients.lastname) AS PatientsFullName,
            patients.gender, patients.dob, patients.patientId,
            visits.visitCat, visits.VisitDate, visits.billMode,
            labRequests.labReqSampleId AS SpecimenNo, labRequests.DrawnDate,
            CONCAT(users.firstname, ' ', users.lastname) AS DrawnBy, visits.drUserId
        FROM labRequests
        JOIN patients ON labRequests.labReqPatientId = patients.patientId
        JOIN cashierSaveds ON labRequests.LabReqCashierSavedReceiptNo = cashierSaveds.cashierSavedReceiptNo
        JOIN visits ON labRequests.labReqVisitId = visits.visit_Id
        JOIN users ON labRequests.labReqSavedByUserId = users.userId
        WHERE labRequests.labReqSampleId = :labReqSampleId",
        [':labReqSampleId' => $labReqSampleId]
    );

    $patientInfo = $patientInfoRow[0];

    // 2. Fetch results for individual tests (e.g., BS with a result)
    $primaryTests = $labReport->query("
        SELECT
            labReports.reportLabReqSampleId,
            tests.testname AS primaryTestName,
            labReports.testResult,
            tests.refRanges,
            tests.unitid
        FROM labReports
        JOIN tests ON tests.testCode = labReports.reportTestCode
        WHERE labReports.reportLabReqSampleId = :labReqSampleId",
        [':labReqSampleId' => $labReqSampleId]
    );

    // 3. Fetch extra tests and subtest results (e.g., RFT -> UREA, CREATININE)
    $subtests = $labReport->query("
        SELECT
            tests.testname AS parentTest,                      -- RFT (primary test)
            extratests.xtraTestName AS subTestName,            -- UREA, CREATININE etc.
            labextratestreports.extratestResults AS subTestResult,
            extratests.xtraRefRanges AS subTestRefRange,
            extratests.xtraUnitid AS subTestUnit
        FROM labextratestreports
        JOIN extratests ON labextratestreports.extraTestReportSubTestCode = extratests.subTestCode
        JOIN tests ON labextratestreports.extraTestReportTestCode = tests.testCode
        WHERE labextratestreports.extraTestReportSampId = :labReqSampleId",
        [':labReqSampleId' => $labReqSampleId]
    );

    // 4. Combine and organize data
    $structuredReports = [];

    // Process primary tests (like BS)
    foreach ($primaryTests as $primaryTest) {
        $structuredReports[$primaryTest->primaryTestName] = [
            'primaryTestResult' => $primaryTest->testResult,
            'subtests' => [] // Initialize empty subtests array
        ];
    }

    // Add subtests under their respective parent test (like RFT -> UREA, CREATININE)
    if (is_array($subtests)) {
      foreach ($subtests as $subtest) {
          $parentTest = $subtest->parentTest;

          // If the parent test (e.g., RFT) doesn't exist in `$structuredReports`, add it
          if (!isset($structuredReports[$parentTest])) {
              $structuredReports[$parentTest] = [
                  'primaryTestResult' => null, // No direct result for the parent test
                  'subtests' => []
              ];
          }

          // Add the subtest under the parent test
          $structuredReports[$parentTest]['subtests'][] = [
              'name' => $subtest->subTestName,
              'result' => $subtest->subTestResult,
              'range' => $subtest->subTestRefRange,
              'unit' => $subtest->subTestUnit
          ];
      }
    }

    // 5. Prepare data to send to the view
    $data = [
        'patientInfo' => $patientInfo,
        'structuredReports' => $structuredReports
    ];
// show($data);die;
    // 6. Load the view with structured data
    require $this->viewsPath("laboratory/laboratory-reports-details");
}

}
