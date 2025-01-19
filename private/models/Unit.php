<?php
/**
 * Unit Class Model
 */
class Unit extends Model
{
  protected $table = "units";
  protected $allowedColumns = [
    'unitname',
    'unitUserId',
    'date',
  ];
  protected $beforeInsert = [
    'makeUnitId',
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
    if (empty($DATA['unitname']))
    {
      $this->errors['unitname'] = "Unit Required!";
    }
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }

// ==========================================================================================
// COLLECT USER INFORMATION FROM USERS TABLE
// get user information from $rows by unitUserId, enriched with relational data
  public function getUserById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'users',                // Related table name where we are looking for user information
      'userId',               // Column in `users` table
      'unitUserId',          // Column in $rows for matching one in users table
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
 * Automatically generates a unique unitId before inserting a new record.
 * This function is used as a hook in the `beforeInsert` array.
 *
 * @param array $data Input data for the new record (associative array).
 * @return array Modified data array with the unique `unitId` added.
 */
  public function makeUnitId($data){
    // Define allowed columns specific to this operation
    $allowedColumns = ['unitId'];
    // Step 1: Generate a unique unitId
    // Calls the `generateUniqueId` function to create a unique ID for the 'unitId' field.
    // The prefix 'UNI-' ensures all unitIds follow the format "UNI-XXX".
    $newUnitId = $this->generateUniqueId('unitId', 'UNI', $allowedColumns);

    // Step 2: Add the generated unitId to the data array
    // The generated ID is assigned to the `unitId` key in the `$data` array.
    $data['unitId'] = $newUnitId;

    // Step 3: Return the modified data array
    // The updated `$data` array now includes the generated `unitId`.
    // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
    return $data;
  }
// ==========================================================================================
}
