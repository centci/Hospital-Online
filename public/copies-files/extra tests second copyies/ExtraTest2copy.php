<?php
/**
 * ExtraTest Class Model
 */
class ExtraTest extends Model
{
  protected $allowedColumns = [
    'xtraTestName',
    'xtraRefRanges',
    'xtraTestCode',
    'xtraUnitid',
    'xtraUserId',
    'xtraTestDate',
  ];

  protected $afterSelect = [
    'getUserById',
    'getUnitById',
  ];
  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
    // show($DATA);die;
    $this->errors = [];
    $xtraTestName_num = 0;
    $xtraRefRanges_num = 0;
    $xtraUnitid_num = 0;
    // ===================TESTS EXTRA VALIDATION======================
    foreach ($DATA as $key => $value)
    {
      if (strstr($key, 'xtraTestName'))
      {
        if (empty($value))
        {
          $this->errors['xtraTestName'.$xtraTestName_num] = "Tests Name Required!";
        }
        $xtraTestName_num++;
      }

      if (strstr($key, 'xtraRefRanges'))
      {
        if (empty($value))
        {
            $this->errors['xtraRefRanges'.$xtraRefRanges_num ] = "Ref Ranges Required!";
        }
        $xtraRefRanges_num++;
      }
      if (strstr($key, 'xtraUnitid'))
      {
        if (empty($value))
        {
          $this->errors['xtraUnitid'.$xtraUnitid_num] = "Unit Required!";
        }
        $xtraUnitid_num++;
      }
    }
    // show($this->errors);die;

    // // Validate Extra Test Name
    // if (empty($DATA['xtraTestName']))
    // {
    //   $this->errors['xtraTestName'] = "Tests Name Required!";
    // }
    // //Validate Extra Test Ref Ranges
    // if (empty($DATA['xtraRefRanges']))
    // {
    //   $this->errors['xtraRefRanges'] = "Ref Ranges Required!";
    // }
    // //Validate Extra Test Units
    // if (empty($DATA['xtraUnitid']))
    // {
    //   $this->errors['xtraUnitid'] = "Unit Required!";
    // }
    // ==================TESTS EXTRA VALIDATION END====================

    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }
  // get user by id
  public function getUserById($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->xtraUserId))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT firstname,lastname,role,username FROM users WHERE id = :id LIMIT 1";
        $user = $db->query($query,['id'=>$row->xtraUserId]);
        if (!empty($user))
        {
          $user[0]->name = esc($user[0]->firstname ." ". $user[0]->lastname);
          $rows[$key]->userRow = $user[0];
        }
      }
    }
    return $rows;
  }

  // get Tests Unit by id
  public function getUnitById($rows)
  {
    $db = New Database();
    if (!empty($rows[0]->xtraUnitid))
    {
      foreach ($rows as $key => $row)
      {
        $query = "SELECT * FROM units WHERE id = :id LIMIT 1";
        $unit = $db->query($query,['id'=>$row->xtraUnitid]);
        if (!empty($unit))
        {
          $rows[$key]->unitRow = $unit[0];
        }
      }
    }
    return $rows;
  }
}
