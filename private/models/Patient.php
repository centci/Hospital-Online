<?php
/**
 * Patients Class Model
 */
class Patient extends Model
{
  protected $table = 'patients'; // Explicitly set the table name

  protected $allowedColumns = [
    'title',
    'patientId',
    'firstname',
    'middlename',
    'lastname',
    'dob',
    'gender',
    'phone',
    'nok',
    'nokphone',
    'country',
    'district',
    'county',
    'subcounty',
    'village',
    'userId',
    'date',
  ];

  protected $beforeInsert = [
    'make_patientNo',
  ];
  protected $afterSelect = [
    'getUserById',
    'getDrUserById',
    'getAge'
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate Title
    if (empty($DATA['title'])) {
      $this->errors['title'] = "Title Is Required.";
    }
    // Validate first name
    if (empty($DATA['firstname'])) {
      $this->errors['firstname'] = "First Name Is Required.";
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['firstname']))
    {
      $this->errors['firstname'] = 'Names Only Letters Allowed.';
    }
    // Validate Middle name
    // if (!empty($DATA['middlenamme'])) {
    //   $this->errors['middlenamme'] = "Middle Name Is Required.";
    // }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['middlenamme']))
    // {
    //   $this->errors['middlenamme'] = 'Names Only Letters Allowed.';
    // }
    // Validate last name
    if (empty($DATA['lastname'])) {
      $this->errors['lastname'] = "Last Name Is Required.";
    }elseif (!preg_match('/^[a-zA-Z]+$/', $DATA['lastname']))
    {
      $this->errors['lastname'] = 'Names Only Letters Allowed.';
    }
    // Validate Date Of Birth
    if (empty($DATA['dob'])) {
      $this->errors['dob'] = "Birthday Is Required.";
    }

    // Validate Gender
    if (empty($DATA['gender'])) {
      $this->errors['gender'] = "Please Select Gender.";
    }
    // Validate Patient Phone
    if (!preg_match('/^[0-9]+$/', $DATA['phone']))
    {
      $this->errors['phone'] = "Only Numbers 0-9 Allowed.";
    }
    // Validate Next Of Kin
    if (empty($DATA['nok'])) {
      $this->errors['nok'] = "NOK Name Is Required.";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['nok']))
    {
      $this->errors['nok'] = 'Only Letters Allowed.';
    }
    // Validate NOK Phone
    if (!preg_match('/^[0-9]+$/', $DATA['nokphone']))
    {
      $this->errors['nokphone'] = "Only Numbers 0-9 Allowed.";
    }
    // Validate Country
    if (empty($DATA['country'])) {
      $this->errors['country'] = "Please Select Country.";
    }
    // Validate District
    if (empty($DATA['district'])) {
      $this->errors['district'] = "District Is Required.";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['district']))
    {
      $this->errors['district'] = 'Only Letters Allowed.';
    }
    // Validate County
    if (empty($DATA['county'])) {
      $this->errors['county'] = "County Is Required.";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['county']))
    {
      $this->errors['county'] = 'Only Letters Allowed.';
    }
    // Validate Sub-County
    if (empty($DATA['subcounty'])) {
      $this->errors['subcounty'] = "Sub-County Required.";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['subcounty']))
    {
      $this->errors['subcounty'] = 'Only Letters Allowed.';
    }

    // Validate Village
    if (empty($DATA['village'])) {
      $this->errors['village'] = "Village Required.";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['village']))
    {
      $this->errors['village'] = 'Only Letters Allowed.';
    }

    if (count($this->errors) == 0) {
      return true;
    }
    return false;
  }

  // run function to make Patients id
  public function make_patientNo($patientNo)
  {
    $db = new Database();
    $query = "SELECT id,patientId FROM patients ORDER BY id DESC LIMIT 1";
    $ptn_no = $db->query($query);

    if (is_array($ptn_no))
    {
      $lastid = (int)$ptn_no[0]->patientId;
    }
    if (!empty($lastid))
    {
      $substrOfPtn_Num = substr($lastid,4);
      $ptn_num1 = str_pad(($substrOfPtn_Num + 1),5,0, STR_PAD_LEFT);
      $ptn_num2 = (substr($lastid,0,-5));

      if ($ptn_num2 != date('Y'))
      {
        $patientNo['patientId']  = date('Y')."00001";
      }else {
        $patientNo['patientId'] = $ptn_num2.$ptn_num1;
      }
      // show($patientNo);die;
    }
    else
    {
      $patientNo['patientId']  = date('Y')."00001";
    }
    return $patientNo;
  }
  // get getAge
  public function getAge($rows)
  {
    if (!empty($rows))
    {
      foreach ($rows as $key => $row)
      {
        if (!empty($row))
        {
          $age = $rows[0]->dob;
          $rows[$key]->Age = intval(substr(date('Ymd') - date('Ymd',strtotime($age)), 0, -4))." Yrs";
        }
      }
    }
    return $rows;
  }

  // get user by id
  public function getUserById($rows)
  {
    $db = new Database();
    if (!empty($rows[0]->userId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT firstname,lastname,username FROM users WHERE id = :id LIMIT 1";
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
  // This function is specific to visit table, get Doctor role from Roles Table by drUserId from visits
  public function getDrUserById($rows)
  {
    $db = new Database();
    if (!empty($rows[0]->drUserId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT firstname,lastname FROM users WHERE userId = :userId LIMIT 1";
        $user = $db->query($query,['userId'=>$row->drUserId]);

        if (!empty($user))
        {

          $rows[$key]->DrName = esc($user[0]->firstname ." ". $user[0]->lastname);
        }
      }
    }
    // show($rows);die;

    return $rows;
  }

}
