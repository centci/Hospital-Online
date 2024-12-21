<?php
/**
 * LabSection Class Model
 */
class LabSection extends Model
{
  protected $allowedColumns = [
    'labname',
    'userId',
    'date',
    'labsec_id',
  ];
  protected $afterSelect = [
    'getUserById',
  ];
  protected $beforeInsert = [
    'make_labsec_id',
  ];
  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate User Name
    if (empty($DATA['labname']))
    {
      $this->errors['labname'] = "Tests Lab Is Required!";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['labname']))
    {
      $this->errors['labname'] = "Only Letters Allowed!";
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

// Make extra Lab Section id
  public function make_labsec_id($id)
  {
    $db = New Database();
    $query = "SELECT * FROM labsections ORDER BY id DESC LIMIT 1";
    $labSecId = $db->query($query);
    if (empty($labSecId))
    {
      $id['labsec_id'] = 1;
    }
    else {
      $id['labsec_id'] = $labSecId[0]->labsec_id + 1;
    }
    return $id;
  }
}
