<?php
/**
 * Visit Class Model
 */
class Visit extends Model
{
  protected $allowedColumns = [
    'visit_Id',
    'patientId',
    'visitCat',
    'billTo',
    'billMode',
    'insuranceNo',
    'dr_Specliz_id',
    'departmentId',
    'drUserId',
    'userId',
    'visitPriority',
    'VisitDate'
  ];
  protected $beforeInsert = [
    // 'make_request_no',
  ];
  protected $afterSelect = [
    'getUserById',
    'patientInfo',
    'getAge',
    'test_sample',
    'sample_container',
    'departmentInfo',
    'insuranceInfoById',
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
    // show($DATA);die;

    $this->errors = [];
    // Validate Category
    if (empty($DATA['visitCat']))
    {
      $this->errors['visitCat'] = "Visit Category Required!";
    }

    // Validate Bill Mode
    if (empty($DATA['billMode']))
    {
      $this->errors['billMode'] = "Bill Mode Required!";
    }

    // Validate Bill To
    if (empty($DATA['billTo']))
    {
      $this->errors['billTo'] = "Customer to bill Required!";
    }

    if (!empty($DATA['visitCat']))
    {
      if ($DATA['visitCat'] == "consultation")
      {
        // Validate Specialist
        if (empty($DATA['dr_Specliz_id']))
        {
          $this->errors['dr_Specliz_id'] = "Specialist Required!";
        }
        // Validate Doctor
        if (empty($DATA['drUserId']))
        {
          $this->errors['drUserId'] = "Doctor Required!";
        }
      }

      // Validate Department
      if ($DATA['visitCat'] == "self request")
      {
        if (empty($DATA['departmentId']))
        {
          $this->errors['departmentId'] = "Department Required!";
        }
      }
    }

    // Validate visit Priority
    if (empty($DATA['visitPriority']))
    {
      $this->errors['visitPriority'] = "Visit Priority Required!";
    }

    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }
  // get getAge
  public function getAge($rows)
  {
    // show($rows[0]);die;

    if (!empty($rows))
    {
      foreach ($rows as $key => $row)
      {
        if (!empty($row))
        {
          $age = $rows[0]->patientRow->dob;
          if (!empty($age)) {
            // code...
            $rows[$key]->Age = intval(substr(date('Ymd') - date('Ymd',strtotime($age)), 0, -4))." Years";
          }
        }
      }
    }
    return $rows;
  }
  // get user by id
  public function getUserById($rows)
  {
    // show($rows);die;

    $db = New Database();
    if (!empty($rows[0]->userId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT firstname,lastname,role,username FROM users WHERE id = :id LIMIT 1";
        $user = $db->query($query,['id'=>$row->userId]);
        if (!empty($user))
        {
          $user[0]->name = esc($user[0]->firstname ." ". $user[0]->lastname);
          $rows[$key]->userRow = $user[0];
        }
      }
    }
    return $rows;
  }
  // get insuranceInfo by id
  public function insuranceInfoById($rows)
  {
    // show($rows[0]->billTo);die;
    $db = New Database();
    if (!empty($rows[0]->billTo))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM insurances WHERE id = :billTo LIMIT 1";
        $insurance = $db->query($query,['billTo'=>$row->billTo]);

        if (!empty($insurance))
        {
          $rows[$key]->insuranceRow = $insurance[0];
        }
      }
    }
    return $rows;
  }
  // get patients by patientId
  public function patientInfo($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->patientId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM patients WHERE patientId = :patientId LIMIT 1";
        $patient = $db->query($query,['patientId'=>$row->patientId]);
        if (!empty($patient))
        {
          $patient[0]->name = esc($patient[0]->firstname ." ".$patient[0]->middlename." ".$patient[0]->lastname);
          $rows[$key]->patientRow = $patient[0];
        }
      }
    }
    // show($rows);die;
    return $rows;
  }

  // get department information by departmentId
  public function departmentInfo($rows)
  {
    // show($rows);die;
    $db = New Database();
    if (!empty($rows))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT department FROM departments WHERE id = :departmentId LIMIT 1";
        $department = $db->query($query,['departmentId'=>$row->departmentId]);

        if (!empty($department))
        {
          $rows[$key]->departmentRow = $department[0];
        }
      }
    }
    return $rows;
  }

  // get Sample by sampleid
  public function test_sample($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->sampleid))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM samples WHERE id = :sampleid LIMIT 1";
        $sample = $db->query($query,['sampleid'=>$row->sampleid]);
        if (!empty($sample))
        {
          $sample[0]->SAMPLENAME = strtoupper($sample[0]->samplename);
          $rows[$key]->sampleRow = $sample[0];
        }
      }
    }
    return $rows;
  }
  // get Sample Container by containerid
  public function sample_container($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->containerid))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM containers WHERE id = :containerid LIMIT 1";
        $container = $db->query($query,['containerid'=>$row->containerid]);
        if (!empty($container))
        {
          // $container[0]->name = esc($container[0]->containername);
          $rows[$key]->containerRow = $container[0];
        }
      }
    }
    return $rows;
  }
}
