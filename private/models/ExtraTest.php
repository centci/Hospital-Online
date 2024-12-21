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
