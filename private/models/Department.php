<?php
/**
 * Department Class Model
 */
class Department extends Model
{
  protected $allowedColumns = [
    'department',
    'userId',
    'date',
    'dept_id',
  ];
  protected $beforeInsert = [
    'make_dept_id',
  ];
  protected $afterSelect = [
    'getUserById',
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate User Name
    if (empty($DATA['department']))
    {
      $this->errors['department'] = "Department Required!";
    }
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
// Make Extra Department id
  public function make_dept_id($id)
  {
    $db = New Database();
    $query = "SELECT * FROM departments ORDER BY id DESC LIMIT 1";
    $depId = $db->query($query);
    if (empty($depId))
    {
      $id['dept_id'] = 1;
    }
    else {
      $id['dept_id'] = $depId[0]->dept_id + 1;
    }
    return $id;
  }
}
