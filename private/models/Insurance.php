<?php
/**
 * Insurance Class Model
 */
class Insurance extends Model
{
  protected $allowedColumns = [
    'insuranceName',
    'userId',
    'date',
  ];

  protected $afterSelect = [
    'getUserById',
  ];

  protected $beforeInsert = [
    'make_insur_id',
  ];


  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate User Name
    if (empty($DATA['insuranceName']))
    {
      $this->errors['insuranceName'] = "Insurance Required!";
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

// Make extra Insurance id
  public function make_insur_id($id)
  {
    $db = New Database();
    $query = "SELECT * FROM insurances ORDER BY id DESC LIMIT 1";
    $insurId = $db->query($query);
    if (empty($insurId))
    {
      $id['insur_id'] = 1;
    }
    else {
      $id['insur_id'] = $insurId[0]->insur_id + 1;
    }
    return $id;
  }
}
