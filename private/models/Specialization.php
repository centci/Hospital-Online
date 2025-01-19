<?php
/**
 * Specialization Class Model
 */
class Specialization extends Model
{
  protected $table = 'specializations'; // Explicitly set the table name

  protected $allowedColumns = [
    'specialized',
    'specializeUserId',
    'date',
  ];
  protected $beforeInsert = [
    'make_specializeId',
  ];
  protected $afterSelect = [
    'getUserById',
  ];
// ==========================================================================================
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
// ==========================================================================================
// COLLECT USER INFORMATION FROM USERS TABLE
// get user information from $rows by deptUserId, enriched with relational data
 public function getUserById($rows) {
   $result = $this->getRelatedData(
     $rows,                  // The existing dataset
     'users',                // Related table name where we are looking for user information
     'userId',               // Column in `users` table
     'specializeUserId',     // Column in $rows for matching one in users table
     ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
     ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
     'userInfo',              // Key where related info will be attached
     'USR-'                  // prefix for userId here if needed, just incase database userId = 12 instead of USR-002
   );

   return $result;
 }
// ==========================================================================================
/**
 * Automatically generates a unique specializeId before inserting a new record.
 * This function is used as a hook in the `beforeInsert` array.
 *
 * @param array $data Input data for the new record (associative array).
 * @return array Modified data array with the unique `specializeId` added.
 */
public function make_specializeId($data)
{
  // Define allowed columns specific to this operation
  $allowedColumns = ['specializeId'];

  // Step 1: Generate a unique specializeId
  // Calls the `generateUniqueId` function to create a unique ID for the 'specializeId' field.
  // The prefix 'SPC-' ensures all specializeIds follow the format "SPC-XXX".
  $newSpecializeId = $this->generateUniqueId('specializeId', 'SPC',$allowedColumns);

  // Step 2: Add the generated specializeId to the data array
  // The generated ID is assigned to the `specializeId` key in the `$data` array.
  $data['specializeId'] = $newSpecializeId;

  // Step 3: Return the modified data array
  // The updated `$data` array now includes the generated `specializeId`.
  // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
  return $data;
}
// ==========================================================================================
}
