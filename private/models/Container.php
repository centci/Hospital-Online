<?php
/**
 * Container Class Model
 */
class Container extends Model
{

  protected $table = "containers";
  protected $allowedColumns = [
    'containername',
    'containerUserId',
    'date',
    'containerId',
  ];

  protected $afterSelect = [
    'getUserById',
  ];

  protected $beforeInsert = [
    'makeContainerId',
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
// =======================================================================================================
// Function to get user information by ID, enriched with relational data
  public function getUserById($rows) {

    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'users',                // Related table name where we are looking for user information
      'userId',               // Column in `users` table
      'containerUserId',      // Column in $rows for matching one in users table
      ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
      ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
      'userInfo',              // Key where related info will be attached
      'USR-'                   /* prefix for userId here if needed, just incase database userId = 12 instead
                                  of USR-002   */
    );
    return $result;
  }

// ==========================================================================================
// Make extra Containe Id
  /**
   * Automatically generates a unique containerId before inserting a new record.
   * This function is used as a hook in the `beforeInsert` array.
   *
   * @param array $data Input data for the new record (associative array).
   * @return array Modified data array with the unique `containerId` added.
   */
  public function makeContainerId($data){
    // Define allowed columns specific to this operation
    $allowedColumns = ['containerId'];
    // Step 1: Generate a unique containerId
    // Calls the `generateUniqueId` function to create a unique ID for the 'containerId' field.
    // The prefix 'CON-' ensures all containerIds follow the format "CON-XXX".
    $newContainerId = $this->generateUniqueId('containerId', 'CON', $allowedColumns);

    // Step 2: Add the generated containerId to the data array
    // The generated ID is assigned to the `containerId` key in the `$data` array.
    $data['containerId'] = $newContainerId;
// show($data);die;
    // Step 3: Return the modified data array
    // The updated `$data` array now includes the generated `containerId`.
    // Returning this array ensures the ID will be part of the data when it gets inserted into the database.
    return $data;
  }
// ==========================================================================================
}
