<?php
/**
 * LabSection Class Model
 */
class LabSection extends Model
{
  protected $table = 'labsections'; // Explicitly set the table name

  protected $allowedColumns = [
    'labname',
    'labSectionUserId',
    'date',
    'labSectionId',
  ];
  protected $afterSelect = [
    'getUserById',
  ];
  protected $beforeInsert = [
    'make_labSectionId',
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
// ==========================================================================================
// COLLECT USER INFORMATION FROM USERS TABLE
// get user information from $rows by labSectionUserId, enriched with relational data
 public function getUserById($rows) {
   $result = $this->getRelatedData(
     $rows,                  // The existing dataset
     'users',                // Related table name where we are looking for user information
     'userId',               // Column in `users` table
     'labSectionUserId',     // Column in $rows for matching one in users table
     ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
     ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
     'userInfo',              // Key where related info will be attached
     'USR-'                  // prefix for userId here if needed, just incase database userId = 12 instead of USR-002
   );

   return $result;
 }
// ==========================================================================================
  /**
   * Automatically generates a unique labSectionId before inserting a new record.
   * This function is used as a hook in the `beforeInsert` array.
   *
   * @param array $data Input data for the new record (associative array).
   * @return array Modified data array with the unique `labSectionId` added.
   */
  public function make_labSectionId($data)
  {
    // Define allowed columns specific to this operation
    $allowedColumns = ['labSectionId'];

    // Step 1: Generate a unique labSectionId
    // Calls the `generateUniqueId` function to create a unique ID for the 'labSectionId' field.
    // The prefix 'LSC-' ensures all labSectionIds follow the format "LSC-XXX".
    $newlabSectionId = $this->generateUniqueId('labSectionId', 'LSC', $allowedColumns);

    // Step 2: Add the generated labSectionId to the data array
    // The generated ID is assigned to the `labSectionId` key in the `$data` array.
    $data['labSectionId'] = $newlabSectionId;

    // Step 3: Return the modified data array
    // The updated `$data` array now includes the generated `labSectionId`.
    // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
    return $data;
  }

// ==========================================================================================
}
