<?php
/**
 * Insurance Class Model
 */
class Insurance extends Model
{
  protected $table = 'insurances'; // Explicitly set the table name
  protected $allowedColumns = [
    'insuranceName',
    'insuranceUserId',
    'date',
  ];

  protected $afterSelect = [
    'getUserById',
  ];

  protected $beforeInsert = [
    'make_insuranceId',
  ];

  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
    $this->errors = [];
    // Validate
    if (empty($DATA['insuranceName']))
    {
      $this->errors['insuranceName'] = "Lab Insurance Is Required!";
    }elseif (!preg_match('/^[a-zA-Z ]+$/', $DATA['insuranceName']))
    {
      $this->errors['insuranceName'] = "Only Letters Allowed!";
    }
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
  }
// ==========================================================================================
// COLLECT USER INFORMATION FROM USERS TABLE
// get user information from $rows by insuranceUserId, enriched with relational data
 public function getUserById($rows) {
   $result = $this->getRelatedData(
     $rows,                  // The existing dataset
     'users',                // Related table name where we are looking for user information
     'userId',               // Column in `users` table
     'insuranceUserId',      // Column in $rows for matching one in users table
     ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
     ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
     'userInfo',              // Key where related info will be attached
     'USR-'                  // prefix for userId here if needed, just incase database userId = 12 instead of USR-002
   );

   return $result;
 }
// ==========================================================================================

// Make extra Insurance id
  /**
   * Automatically generates a unique insuranceId before inserting a new record.
   * This function is used as a hook in the `beforeInsert` array.
   *
   * @param array $data Input data for the new record (associative array).
   * @return array Modified data array with the unique `insuranceId` added.
   */
  public function make_insuranceId($data){
    // Define allowed columns specific to this operation
    $allowedColumns = ['insuranceId'];
    // Step 1: Generate a unique insuranceId
    // Calls the `generateUniqueId` function to create a unique ID for the 'insuranceId' field.
    // The prefix 'DEP-' ensures all insuranceIds follow the format "DEP-XXX".
    $newInsuranceId = $this->generateUniqueId('insuranceId', 'INS', $allowedColumns);

    // Step 2: Add the generated insuranceId to the data array
    // The generated ID is assigned to the `insuranceId` key in the `$data` array.
    $data['insuranceId'] = $newInsuranceId;

    // Step 3: Return the modified data array
    // The updated `$data` array now includes the generated `insuranceId`.
    // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
    return $data;
  }
// ==========================================================================================
}
