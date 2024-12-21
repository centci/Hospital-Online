<?php
/**
 * Test Class Model
 */
class Test extends Model
{
  protected $allowedColumns = [
    'toggleswitch',
    'testname',
    'xtraTestCode',
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
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate Tests Name
    if (empty($DATA['testname']))
    {
      $this->errors['testname'] = "Test Name Required!";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['testname']))
    {
      $this->errors['testname'] = "Test Name Allows Letters Only!";
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
    if (empty($DATA['toggleswitch'])) {
      if (empty($DATA['refRanges']))
      {
        $this->errors['refRanges'] = "Refrance Ranges Required!";
      }
    }

    //Validate Test Units
    if (empty($DATA['toggleswitch'])) {
      if (empty($DATA['unitid']))
      {
        $this->errors['unitid'] = "Unit Required!";
      }
    }

    // ===================TESTS EXTRA VALIDATION======================
    if (!empty($DATA['toggleswitch'])) {
    //   foreach ($DATA as $key => $value)
    //   {
    //     if (strstr($key, 'xtraTestName'))
    //     {
    //       if (empty($value))
    //       {
    //         $this->errors['xtraTestName'] = "Tests Name Required!";
    //       }
    //     }
    //
    //     if (strstr($key, 'xtraRefRanges'))
    //     {
    //       if (empty($value))
    //       {
    //           $this->errors['xtraRefRanges'] = "Ref Ranges Required!";
    //       }
    //     }
    //     if (strstr($key, 'xtraUnitid'))
    //     {
    //       if (empty($value))
    //       {
    //         $this->errors['xtraUnitid'] = "Unit Required!";
    //       }
    //     }
    //   }
      // Validate Extra Test Name
      if (empty($DATA['xtraTestName']))
      {
        $this->errors['xtraTestName'] = "Tests Name Required!";
      }
      //Validate Extra Test Ref Ranges
      if (empty($DATA['xtraRefRanges']))
      {
        $this->errors['xtraRefRanges'] = "Ref Ranges Required!";
      }
      //Validate Extra Test Units
      if (empty($DATA['xtraUnitid']))
      {
        $this->errors['xtraUnitid'] = "Unit Required!";
      }
    }
    // ==================TESTS EXTRA VALIDATION END====================

    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }

  // run function to make testCode id
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
