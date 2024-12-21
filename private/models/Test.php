<?php
/**
 * Test Class Model
 */
class Test extends Model
{
  protected $allowedColumns = [
    'toggleswitch',
    'testname',
    'cost',
    'insurance_cost',
    'labSecId',
    'sampleid',
    'containerid',
    'refRanges',
    'unitid',
    'userId',
    'testCode',
    'testStatus',
    'testDate',
  ];

  protected $beforeInsert = [
    'make_testCode',
   ];

  protected $afterSelect = [
    'getUserById',
    'getLabById',
    'getSampleById',
    'getUnitById',
    'getSampleContainerById'
  ];

  // form validation before inserting data
  public function validate($DATA, $id = null)
  {
  	$this->errors = [];
    if (isset($DATA['testname']))
    {
      // Validate Tests Name
      if (empty($DATA['testname']))
      {
        $this->errors['testname'] = "Test Name Required!";
      }elseif (!preg_match('/^[a-zA-Z0-9 ]+$/', $DATA['testname']))
      {
        $this->errors['testname'] = "Test Name Allows Letters Only!";
      }

      // Validate Normal Tests Cost
      if (empty($DATA['cost']))
      {
        $this->errors['cost'] = "Test Cost Required!";
      }elseif (!preg_match('/^[0-9]+$/', $DATA['cost']))
      {
        $this->errors['cost'] = "Test Cost Allows Numbers Only!";
      }

      // Validate Normal Tests Cost
      if (empty($DATA['insurance_cost']))
      {
        $this->errors['insurance_cost'] = "Insurance Test Cost Required!";
      }elseif (!preg_match('/^[0-9]+$/', $DATA['insurance_cost']))
      {
        $this->errors['insurance_cost'] = "Insurance Test Cost Numbers Letters Only!";
      }

      //Validate lab department
      if (empty($DATA['labSecId']))
      {
        $this->errors['labSecId'] = "Lab Section Required!";
      }
      //Validate Test Status
      if (empty($DATA['testStatus']))
      {
        $this->errors['testStatus'] = "Test Status Required!";
      }

      //Validate Sample Type
      if (empty($DATA['sampleid']))
      {
        $this->errors['sampleid'] = "Sample Type Required!";
      }

      //Validate Sample Container
      if (empty($DATA['containerid']))
      {
        $this->errors['containerid'] = "Sample Container Required!";
      }

      //Validate Test Refrance Ranges
      if (empty($DATA['toggleswitch']))
      {
        if (empty($DATA['refRanges']))
        {
          $this->errors['refRanges'] = "Refrance Ranges Required!";
        }
      }

      //Validate Test Units
      if (empty($DATA['toggleswitch']))
         {
        if (empty($DATA['unitid']))
        {
          $this->errors['unitid'] = "Unit Required!";
        }
      }
    }

    // ===================TESTS EXTRA VALIDATION======================
    // Define the base keys to be validated
    //you can add as many as you want depending on the field you want to check error from your form
    $baseKeys = ['xtraTestCode', 'subTestCode', 'xtraTestName', 'xtraRefRanges', 'xtraUnitid'];
    $suffixes = range(0, 20); // Using range to create an array of suffixes from 0 to 20

      // Define an associative array to store display names for the fields and errors messages
      $fieldDisplayNames = [
        'xtraTestCode' => 'Extra Test Code',
        'subTestCode' => 'Sub Test Code',
        'xtraTestName' => 'Extra Test Name',
        'xtraRefRanges' => 'Extra Ref Ranges',
        'xtraUnitid' => 'Extra Unit Id'
      ];//you can add as many as you can.

      // Iterate through each base key and suffix combination to validate the fields
      foreach ($baseKeys as $baseKey) {
        foreach ($suffixes as $suffix) {
          $completeKey = $baseKey . '_' . $suffix; // Construct the complete key

          // Check if the complete key exists in the data
          if (array_key_exists($completeKey, $DATA)) {
            $value = $DATA[$completeKey]; // Get the value of the complete key

            // If the value is empty, generate an error message
            if (empty($value)) {
              // Retrieve the field display name or fallback to 'Unknown Field'
              $fieldName = isset($fieldDisplayNames[$baseKey]) ? $fieldDisplayNames[$baseKey] : 'Unknown Field';

              // Store the error message in the errors array
              $this->errors[$completeKey] = "The $fieldName is Required";
            }
          }
        }
      }

    // ==================TESTS EXTRA VALIDATION END====================

    // If there are no errors, return true; otherwise, return false
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
    // the end
  }

  //the run function to make testCode id
  public function make_testCode($testCode)
  {
    $db = New Database();
    $query = "SELECT testCode FROM tests ORDER BY id DESC LIMIT 1";
    $Tcode = $db->query($query);

    if (is_array($Tcode))
    {
      $lastid = $Tcode[0]->testCode;
    }
    if (!empty($lastid))
    {
      $substrOfTestCode_Num = substr($lastid,3);
      $testCode['testCode'] = str_pad(($substrOfTestCode_Num + 1),4,0, STR_PAD_LEFT);
      $testCode['testCode'] = 'LAB'.$testCode['testCode'];
    }
    else
    {
      $testCode['testCode']  = 'LAB'."0001";
    }
    return $testCode;
  }

  // get user by id
  public function getUserById($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->userId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT id, firstname,lastname,role,username FROM users WHERE id = :id LIMIT 1";
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
  // get lab Section by id
  public function getLabById($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->labSecId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM labsections WHERE id = :id LIMIT 1";
        $labSec = $db->query($query,['id'=>$row->labSecId]);
        if (!empty($labSec))
        {
          $rows[$key]->labSectionRow = $labSec[0];
        }
      }
    }
    return $rows;
  }
  // get sample type by id
  public function getSampleById($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->sampleid))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM samples WHERE id = :id LIMIT 1";
        $sample = $db->query($query,['id'=>$row->sampleid]);
        if (!empty($sample))
        {
          $rows[$key]->sampleRow = $sample[0];
        }
      }
    }
    return $rows;
  }
  // get Tests Unit by id
  public function getUnitById($rows)
  {
    // show($rows);die;
    $db = New Database();
    if (!empty($rows[0]->unitid))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM units WHERE unit_id = :unit_id LIMIT 1";
        $unit = $db->query($query,['unit_id'=>$row->unitid]);
        if (!empty($unit))
        {
          $rows[$key]->unitRow = $unit[0];
        }
        // show($rows);die;
      }
    }
    return $rows;
  }
  // get Tests container by id
  public function getSampleContainerById($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->containerid))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM containers WHERE id = :id LIMIT 1";
        $container = $db->query($query,['id'=>$row->containerid]);
        if (!empty($container))
        {
          $rows[$key]->containerRow = $container[0];
        }
      }
    }
    return $rows;
  }

}
