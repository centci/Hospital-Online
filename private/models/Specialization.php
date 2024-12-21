<?php
/**
 * Specialization Class Model
 */
class Specialization extends Model
{
  protected $allowedColumns = [
    'specialized',
    'userId',
    'date',
  ];

  protected $afterSelect = [
    'getUserById',
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate specialized Name
    if (empty($DATA['specialized']))
    {
      $this->errors['specialized'] = "Role Required!";
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
}