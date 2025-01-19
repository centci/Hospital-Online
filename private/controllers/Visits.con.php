<?php
defined("ABSPATH") ? "" : die('Not allowed To Access This Page Directly');

/**
 * Visits controller
 */
class Visits extends Controller
{
// Patients to consult Doctors
public function index($id = null)
{
  $errors = [];
  if (!Auth::logged_in())
  {
    $this->redirect('home');
  }
  $visit = new Visit();
  $rows = $visit->query("SELECT * FROM Visits WHERE visitCat ='consultation'");

  require $this->viewsPath("visits/visit-consultation");
}

// Patients with self Request
public function selfrequest($visit_Id = null,$patientId = null)
{
  $errors = [];
  if (!Auth::logged_in())
  {
    $this->redirect('home');
  }
  $visit = new Visit();
  $rows = $visit->query("SELECT * FROM Visits WHERE visitCat ='self request'");

  require $this->viewsPath("visits/visit-self-request");
}

public function search($id = null)
{
  $errors = [];
  if (!Auth::logged_in())
  {
    $this->redirect('home');
  }
  $patient = new Patient();
  $row_data = file_get_contents("php://input");

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if (!empty($row_data))
    {
      $OBJ = json_decode($row_data,true);
      if (is_array($OBJ))
      {
        if ($OBJ['data_type'] == "search")
        {
          if (!empty($OBJ['text']))
          {
            // Search is being performed
            $text = "%".$OBJ['text']."%";
            $search_columns = "firstname like :find || middlename like :find || lastname like :find || phone like :find || patientId like :find";
            $query = "SELECT * FROM patients WHERE $search_columns LIMIT 10";
            $ptn = $patient->query($query,['find'=>$text]);
          }else
          {
            $ptn = $patient->findAll();
          }
          echo json_encode($ptn);
        }
      }
    }
   die;
  }
  require $this->viewsPath("Visits/Visit-search");
}

public function create($id = null)
{
  $errors = [];
  if (!Auth::logged_in())
  {
    $this->redirect('home');
  }
  $visits = new Visit();
  $patient = new Patient();
  $doctors = new Role();
  $specialization = new Specialization();
  $department = new Department();
  $insurance = new Insurance();

  $row = $patient->first('patientId',$id);
  $doctRow = $doctors->where('role','doctor');
  $specialistRow = $specialization->findAll();
  $departmentRow = $department->findAll();
  $insuranceRow = $insurance->findAll();

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if ($visits->validate($_POST))
    {
      $_POST['userId'] = Auth::getUserId();
      $_POST['VisitDate'] = date('Y-m-d H:i:s');
      $_POST['visit_Id'] = random_string(10);

      $visits->insert($_POST);
      message('Visit Successfully Saved!');
      $this->redirect("visits/create/".$id);
    }
    // handle errors
    else
    {
    	// errors
    	$errors = $visits->errors;
    }
  }
  require $this->viewsPath("visits/visit-create");
}

public function addvisitrequest($visit_Id = null)
{
  $errors = [];
  if (!Auth::logged_in())
  {
    $this->redirect('home');
  }

  $visits = new Visit();
  $testRow = new Test();

  $visitAndPatientRow = $visits->query("SELECT visits.visit_Id, patients.patientId, visits.VisitDate, visits.departmentId FROM visits JOIN patients ON visits.patientId = patients.patientId WHERE visits.visit_Id = '$visit_Id'");
  $row = $visitAndPatientRow[0];

  // get content from php
  $row_data = file_get_contents("php://input");

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if (!empty($row_data))
    {
      $OBJ = json_decode($row_data,true);
      if (is_array($OBJ))
      {
        if ($OBJ['data_type'] == "search_test")
        {
          $tests = [];

          if (!empty($OBJ['text']))
          {
            // Search is being performed
            $text  = $OBJ['text']."%";
            $query = "SELECT * FROM tests WHERE testname like :find LIMIT 10";
            $tests = $testRow->query($query,['find'=>$text]);
          }else
          {
            $tests = $testRow->where('testStatus','enabled');
          }

          if ($tests)
          {
            $info['data_type'] = 'search_test';
            $info['data'] = $tests;
            $info['visits'] = $row;

            echo json_encode($info);
          }
        }
        else
        if ($OBJ['data_type'] == "submit_test")
        {
          $pendingpayment = new PendingPayment();

          $receipt_no 		= 	random_string(10);
          $testData = $OBJ['text'];
          $loggedinUser = $_POST['userId'] = Auth::getUserId();
          $dateRecorded = $_POST['pendingPayDate'] = date('Y-m-d H:i:s');
          $ptnInfo = $row;

          if (is_array($testData))
          {
            foreach ($testData as $row)
            {
            $testArr = [];
            $testArr['itemCode'] = $row['testCode'];
            $testArr['pendingPayId'] = $receipt_no;
            $testArr['patientNo'] = $ptnInfo->patientId;
            $testArr['pendingPayVisitId'] = $ptnInfo->visit_Id;
            $testArr['departmentId'] = $row['departmentId'];
            $testArr['sentBy'] = $loggedinUser;
            $testArr['pendingPayDate'] = $dateRecorded;

            $pendingpayment->insert($testArr);
            }
          }
          $info['data_type'] = 'submit_test';
          $info['data'] = "Test saved saccessfully";

          echo json_encode($info);
        }
      }
    }
    die();
  }

  require $this->viewsPath("visits/visit-add-request");
}

}
