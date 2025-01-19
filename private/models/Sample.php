<?php
/**
 * Sample Class Model
 */
class Sample extends Model
{
  protected $table = "samples";
  protected $allowedColumns = [
    'sampleId',
    'samplename',
    'sampleUserId',
    'date',
  ];
  protected $beforeInsert = [
    'make_sampleId',
  ];
  protected $afterSelect = [
    'getUserById',
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate User Name
    if (empty($DATA['samplename']))
    {
      $this->errors['samplename'] = "Sample Type Required!";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['samplename']))
    {
      $this->errors['samplename'] = "Sample Type Allows Letters Only!";
    }
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }

// get user by id
  // public function getUserById($rows)
  // {
  //   $db = new Database();
  //   if (!empty($rows[0]->sampleUserId))
  //   {
  //     foreach ($rows as $key => $row)
  //     {
  //       $query = "SELECT firstname,lastname,username FROM users WHERE id = :id LIMIT 1";
  //       $user = $db->query($query,['id'=>$row->sampleUserId]);
  //       if (!empty($user))
  //       {
  //         $user[0]->name = esc($user[0]->firstname ." ". $user[0]->lastname);
  //         $rows[$key]->userRow = $user[0];
  //       }
  //     }
  //   }
  //   return $rows;
  // }

// ==========================================================================================
// COLLECT USER INFORMATION FROM USERS TABLE
// get user information from $rows by sampleUserId, enriched with relational data
  public function getUserById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'users',                // Related table name where we are looking for user information
      'userId',               // Column in `users` table
      'sampleUserId',         // Column in $rows for matching one in users table
      ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
      ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
      'userInfo',              // Key where related info will be attached
      'USR-'                  // prefix for userId here if needed, just incase database userId = 12 instead of USR-002
    );

    return $result;
  }
// ==========================================================================================
// Make extra Sample Id
  /**
   * Automatically generates a unique sampleId before inserting a new record.
   * This function is used as a hook in the `beforeInsert` array.
   *
   * @param array $data Input data for the new record (associative array).
   * @return array Modified data array with the unique `sampleId` added.
   */
  public function make_sampleId($data){
    // Define allowed columns specific to this operation
    $allowedColumns = ['sampleId'];
    // Step 1: Generate a unique sampleId
    // Calls the `generateUniqueId` function to create a unique ID for the 'sampleId' field.
    // The prefix 'SAM-' ensures all sampleIds follow the format "SAM-XXX".
    $newSampleId = $this->generateUniqueId('sampleId', 'SAM', $allowedColumns);

    // Step 2: Add the generated sampleId to the data array
    // The generated ID is assigned to the `sampleId` key in the `$data` array.
    $data['sampleId'] = $newSampleId;

    // Step 3: Return the modified data array
    // The updated `$data` array now includes the generated `sampleId`.
    // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
    return $data;
  }
// ==========================================================================================
}
