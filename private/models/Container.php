<?php
/**
 * Container Class Model
 */
class Container extends Model
{
  protected $allowedColumns = [
    'containername',
    'userId',
    'date',
    'cont_id',
  ];

  protected $afterSelect = [
    'getUserById',
  ];

  protected $beforeInsert = [
    'make_cont_id',
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate User Name
    if (empty($DATA['containername']))
    {
      $this->errors['containername'] = "Container Type Required!";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['containername']))
    {
      $this->errors['containername'] = "Container Type Allows Letters Only!";
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

// Make extra Container id
  public function make_cont_id($id)
  {
    $db = New Database();
    $query = "SELECT * FROM containers ORDER BY id DESC LIMIT 1";
    $contId = $db->query($query);
    if (empty($contId))
    {
      $id['cont_id'] = 1;
    }
    else {
      $id['cont_id'] = $contId[0]->cont_id + 1;
    }
    return $id;
  }
}
