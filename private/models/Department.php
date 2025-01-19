<?php
/**
 * Department Class Model
 */
class Department extends Model
{
  protected $table = 'departments'; // Explicitly set the table name
  protected $allowedColumns = [
    'department',
    'deptUserId',
    'date',
    'deptId',
  ];
  protected $beforeInsert = [
    'make_deptId',
  ];
  protected $afterSelect = [
    'getUserById',
  ];

// ==========================================================================================
  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
    $this->errors = [];
    // Validate User Name
    if (empty($DATA['department']))
    {
      $this->errors['department'] = "Lab Department Is Required!";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['department']))
    {
      $this->errors['department'] = "Only Letters Allowed!";
    }
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }
// ==========================================================================================
// COLLECT USER INFORMATION FROM USERS TABLE
// get user information from $rows by deptUserId, enriched with relational data
  public function getUserById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'users',                // Related table name where we are looking for user information
      'userId',               // Column in `users` table
      'deptUserId',          // Column in $rows for matching one in users table
      ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
      ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
      'userInfo',              // Key where related info will be attached
      'USR-'                  // prefix for userId here if needed, just incase database userId = 12 instead of USR-002
    );

    return $result;
  }
// ==========================================================================================
// Make extra Department Id
  /**
   * Automatically generates a unique deptId before inserting a new record.
   * This function is used as a hook in the `beforeInsert` array.
   *
   * @param array $data Input data for the new record (associative array).
   * @return array Modified data array with the unique `deptId` added.
   */
  public function make_deptId($data){
    // Define allowed columns specific to this operation
    $allowedColumns = ['deptId'];
    // Step 1: Generate a unique deptId
    // Calls the `generateUniqueId` function to create a unique ID for the 'deptId' field.
    // The prefix 'DEP-' ensures all deptIds follow the format "DEP-XXX".
    $newDeptId = $this->generateUniqueId('deptId', 'DEP', $allowedColumns);

    // Step 2: Add the generated deptId to the data array
    // The generated ID is assigned to the `deptId` key in the `$data` array.
    $data['deptId'] = $newDeptId;

    // Step 3: Return the modified data array
    // The updated `$data` array now includes the generated `deptId`.
    // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
    return $data;
  }
// ==========================================================================================
}
