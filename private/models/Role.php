<?php
/**
 * Role Class Model
 */
class Role extends Model
{
  protected $table = 'roles'; // Explicitly set the table name

  protected $allowedColumns = [
    'role',
    'roleUserId',
    'date',
  ];
  protected $beforeInsert = [
    'make_roleId',
  ];
  protected $afterSelect = [
    'getUserById',
  ];

// ==========================================================================================
  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
  	$this->errors = [];
    // Validate Role Name
    if (empty($DATA['role']))
    {
      $this->errors['role'] = "Role Required!";
    }
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }
// ==========================================================================================
  // COLLECT USER INFORMATION FROM USERS TABLE
  // get user information form $rows by roleUserId, enriched with relational data
  public function getUserById($rows) {
   $result = $this->getRelatedData(
     $rows,                  // The existing dataset
     'users',                // Related table name where we are looking for user information
     'userId',               // Column in `users` table
     'roleUserId',          // Column in $rows for matching one in users table
     ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
     ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
     'userInfo',              // Key where related info will be attached
     'USR-'                  // prefix for userId here if needed, just incase database userId = 12 instead of USR-002
   );

   return $result;
  }
// ==========================================================================================
// Make extra Role Id
  /**
   * Automatically generates a unique roleId before inserting a new record.
   * This function is used as a hook in the `beforeInsert` array.
   *
   * @param array $data Input data for the new record (associative array).
   * @return array Modified data array with the unique `roleId` added.
   */
  public function make_roleId($data){
    // Define allowed columns specific to this operation
    $allowedColumns = ['roleId'];
    // Step 1: Generate a unique roleId
    // Calls the `generateUniqueId` function to create a unique ID for the 'roleId' field.
    // The prefix 'ROL-' ensures all roleIds follow the format "ROL-XXX".
    $newRoleId = $this->generateUniqueId('roleId', 'ROL', $allowedColumns);

    // Step 2: Add the generated roleId to the data array
    // The generated ID is assigned to the `roleId` key in the `$data` array.
    $data['roleId'] = $newRoleId;

    // Step 3: Return the modified data array
    // The updated `$data` array now includes the generated `roleId`.
    // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
    return $data;
  }
// ==========================================================================================
}
