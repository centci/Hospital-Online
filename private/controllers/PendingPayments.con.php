<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Admin controller
 */
class PendingPayments extends Controller
{
  public function index($id = null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
      message('Please Login To View The Admin Section');
    }
    // here we are to use SELECT DISTINCT to get record with no duplicate
    $notpaid = new PendingPayment();

    $pendingpayment = $notpaid->query("SELECT DISTINCT pendingPayId, firstname, patientNo, patientId, sentBy, department, pymt_status, pendingPayDate FROM `pendingPayments`
    JOIN patients ON pendingPayments.patientNo = patients.patientId
    JOIN departments ON pendingPayments.departmentId = departments.id WHERE pymt_status='not paid'");

    // show($pendingpayment);die;

    require $this->viewsPath("admin/finance/list-pending-payment");
  }

  // pending payment details
  public function pendingPaymentDetails($id= null, $pendingPayId=null)
  {
    if (!Auth::logged_in())
    {
      $this->redirect('login');
      message('Please Login To View The Admin Section');
    }
    $testdetails = new PendingPayment();
    $patientDetail = new Patient();

    $patientInfo = $patientDetail->first('patientId',$id);

  // get content from php to search tests
  $row_data = file_get_contents("php://input");

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    // show($row_data);die;

    if (!empty($row_data))
    {
      $OBJ = json_decode($row_data,true);
      if (is_array($OBJ))
      {
        if ($OBJ['data_type'] == "test_details")
        {
          $pendingpayment = [];
          // here we are to use JOIN to SELECT record that match from different tables of tests, pendingPayments, patients and department
          $pendingpayment = $testdetails->query("SELECT * FROM `pendingPayments`
          JOIN tests ON pendingPayments.itemCode = tests.testCode
          JOIN departments ON pendingPayments.departmentId = departments.id
          WHERE patientNo='$id' AND pendingPayId='$pendingPayId' AND pymt_status = 'not paid'");

          if ($pendingpayment)
          {
            $info['data_type'] = 'test_details';
            $info['data'] = $pendingpayment;
            echo json_encode($info);
          }
        }else
        if ($OBJ['data_type'] == "submit_items")
        {
          // show($row_data);die;

          $savingpayment = new cashierSaved();
          $pendingpayment = new PendingPayment();
          $db = new Database();

          $itemsData = $OBJ['text'];
          $receipt_no = random_string(10);
          $loggedinUser = $_POST['userId'] = Auth::getUserId();
          $dateRecorded = $_POST['cashierSavedDate'] = date('Y-m-d H:i:s');

          if (is_array($itemsData))
          {
            foreach ($itemsData as $row)
            {
            $itemArr = [];
            $itemArr['cashierSavedReceiptNo'] = $receipt_no;
            $itemArr['cashierSavedTestCode'] = $row['testCode'];
            $itemArr['cashierSavedPendingPayId'] = $row['pendingPayId'];
            $itemArr['cashierSavedBy'] = $loggedinUser;
            $itemArr['cashierSavedDate'] = $dateRecorded;

            $savedItems = $savingpayment->insert($itemArr);

          // UPDATING PENDINGPAYMENTS TABLE AT THE SAME TIME AFTER INSERTING TO CASHIERSAVEDS
            $testCode     =   $itemArr['cashierSavedTestCode']      = $row['testCode'];
            $pendingPayId  =   $itemArr['cashierSavedPendingPayId']   = $row['pendingPayId'];

            $query = "UPDATE pendingPayments SET pymt_status = 'paid' WHERE itemCode = :itemCode AND pendingPayId = :pendingPayId";
            $ptnInfo = $db->query($query,['itemCode'=>$testCode, 'pendingPayId'=>$pendingPayId]);
            }
          }
            $info['data_type'] = 'submit_items';
            $info['data'] = "items saved saccessfully";
            echo json_encode($info);
        }
      }
    }
    die();
  }
    require $this->viewsPath("admin/finance/pending-payment-details");
  }
  public function todaySales()
  {
    $startdate = $_GET['start'] ?? null;
    $enddate = $_GET['end'] ?? null;

    $year = date("Y");
    $month = date("m");
    $day = date("d");

    $db = new Database();
    $query = "SELECT testname,testCode, cost, firstname, lastname, department, cashierSavedReceiptNo, cashierSavedBy, cashierSavedDate FROM `cashierSaveds`
      JOIN tests ON cashierSaveds.cashierSavedTestCode = tests.testCode
      JOIN pendingPayments ON cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
      JOIN patients ON pendingPayments.patientNo = patients.patientId
      JOIN departments ON pendingPayments.departmentId = departments.deptId
      WHERE cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId AND cashierSaveds.cashierSavedTestCode = pendingPayments.itemCode";


    // if both start and end date are set/provide
    if ($startdate && $enddate)
    {
      $query = "SELECT testname,testCode, cost, firstname, lastname, department, cashierSavedReceiptNo, cashierSavedBy, cashierSavedDate FROM `cashierSaveds`
        JOIN tests ON cashierSaveds.cashierSavedTestCode = tests.testCode
        JOIN pendingPayments ON cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId
        JOIN patients ON pendingPayments.patientNo = patients.patientId
        JOIN departments ON pendingPayments.departmentId = departments.deptId
        WHERE cashierSaveds.cashierSavedPendingPayId = pendingPayments.pendingPayId AND cashierSaveds.cashierSavedTestCode = pendingPayments.itemCode AND
        cashierSavedDate BETWEEN '$startdate' AND '$enddate'";
    }

    $todaySales = $db->query($query);

    $totalSales = $db->query("SELECT SUM(cost) AS TotalSales FROM `cashierSaveds` JOIN tests ON cashierSaveds.cashierSavedTestCode = tests.testCode WHERE cashierSaveds.cashierSavedTestCode = tests.testCode AND cashierSavedDate BETWEEN '$startdate' AND '$enddate'");
    if (is_array($totalSales))
    {
     $totalSales = $totalSales[0];
    }

    require $this->viewsPath("admin/finance/today-sales-details");
  }
}
