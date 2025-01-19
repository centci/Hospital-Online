<?php
/**
 * Test Class Model
 */
class Test extends Model
{
  protected $table = "tests";
  protected $allowedColumns = [
    'toggleswitch',
    'testname',
    'cost',
    'insurance_cost',
    'testsLabSectionId',
    'testsSampleId',
    'testsContainerId',
    'refRanges',
    'testsUnitId',
    'testsUserId',
    'testCode',
    'testStatus',
    'testDate',
  ];

  protected $beforeInsert = [
    'make_testCode',
   ];

  protected $afterSelect = [
    'getUserById',
    'getLabById',
    'getSampleById',
    'getUnitById',
    'getSampleContainerById'
  ];

  // form validation before inserting data
  public function validate($DATA, $id = null)
  {
  	$this->errors = [];
    if (isset($DATA['testname']))
    {
      // Validate Tests Name
      if (empty($DATA['testname']))
      {
        $this->errors['testname'] = "Test Name Required!";
      }elseif (!preg_match('/^[a-zA-Z0-9 ]+$/', $DATA['testname']))
      {
        $this->errors['testname'] = "Test Name Allows Letters Only!";
      }

      // Validate Normal Tests Cost
      if (empty($DATA['cost']))
      {
        $this->errors['cost'] = "Test Cost Required!";
      }elseif (!preg_match('/^[0-9]+$/', $DATA['cost']))
      {
        $this->errors['cost'] = "Test Cost Allows Numbers Only!";
      }

      // Validate Normal Tests Cost
      if (empty($DATA['insurance_cost']))
      {
        $this->errors['insurance_cost'] = "Insurance Test Cost Required!";
      }elseif (!preg_match('/^[0-9]+$/', $DATA['insurance_cost']))
      {
        $this->errors['insurance_cost'] = "Insurance Test Cost Numbers Letters Only!";
      }

      //Validate lab department
      if (empty($DATA['testsLabSectionId']))
      {
        $this->errors['testsLabSectionId'] = "Lab Section Required!";
      }
      //Validate Test Status
      if (empty($DATA['testStatus']))
      {
        $this->errors['testStatus'] = "Test Status Required!";
      }

      //Validate Sample Type
      if (empty($DATA['testsSampleId']))
      {
        $this->errors['testsSampleId'] = "Sample Type Required!";
      }

      //Validate Sample Container
      if (empty($DATA['testsContainerId']))
      {
        $this->errors['testsContainerId'] = "Sample Container Required!";
      }

      //Validate Test Refrance Ranges
      if (empty($DATA['toggleswitch']))
      {
        if (empty($DATA['refRanges']))
        {
          $this->errors['refRanges'] = "Refrance Ranges Required!";
        }
      }

      //Validate Test Units
      if (empty($DATA['toggleswitch']))
         {
        if (empty($DATA['testsUnitId']))
        {
          $this->errors['testsUnitId'] = "Unit Required!";
        }
      }
    }

    // ===================TESTS EXTRA VALIDATION======================
    // Define the base keys to be validated
    //you can add as many as you want depending on the field you want to check error from your form
    $baseKeys = ['xtraTestCode', 'subTestCode', 'xtraTestName', 'xtraRefRanges', 'xtraUnitid'];
    $suffixes = range(0, 20); // Using range to create an array of suffixes from 0 to 20

      // Define an associative array to store display names for the fields and errors messages
      $fieldDisplayNames = [
        'xtraTestCode' => 'Extra Test Code',
        'subTestCode' => 'Sub Test Code',
        'xtraTestName' => 'Extra Test Name',
        'xtraRefRanges' => 'Extra Ref Ranges',
        'xtraUnitid' => 'Extra Unit Id'
      ];//you can add as many as you can.

      // Iterate through each base key and suffix combination to validate the fields
      foreach ($baseKeys as $baseKey) {
        foreach ($suffixes as $suffix) {
          $completeKey = $baseKey . '_' . $suffix; // Construct the complete key

          // Check if the complete key exists in the data
          if (array_key_exists($completeKey, $DATA)) {
            $value = $DATA[$completeKey]; // Get the value of the complete key

            // If the value is empty, generate an error message
            if (empty($value)) {
              // Retrieve the field display name or fallback to 'Unknown Field'
              $fieldName = isset($fieldDisplayNames[$baseKey]) ? $fieldDisplayNames[$baseKey] : 'Unknown Field';

              // Store the error message in the errors array
              $this->errors[$completeKey] = "The $fieldName is Required";
            }
          }
        }
      }

    // ==================TESTS EXTRA VALIDATION END====================

    // If there are no errors, return true; otherwise, return false
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
    // the end
  }

  //the run function to make testCode id
  public function make_testCode($testCode)
  {
    $db = new Database();
    $query = "SELECT testCode FROM tests ORDER BY id DESC LIMIT 1";
    $Tcode = $db->query($query);

    if (is_array($Tcode))
    {
      $lastid = $Tcode[0]->testCode;
    }
    if (!empty($lastid))
    {
      $substrOfTestCode_Num = substr($lastid,3);
      $testCode['testCode'] = str_pad(($substrOfTestCode_Num + 1),4,0, STR_PAD_LEFT);
      $testCode['testCode'] = 'LAB'.$testCode['testCode'];
    }
    else
    {
      $testCode['testCode']  = 'LAB'."0001";
    }
    return $testCode;
  }
// =======================================================================================================
// Function to get labsections information from $rows by labSectionId, enriched with relational data
  public function getLabById($rows) {
    // Input: $rows is the dataset containing records from another source (e.g., test results)

    // Call attachRelatedData to enrich the $rows data with related data information
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'labsections',          // Related table name where we are looking for labsections information
      'labSectionId',         // Column in `labsections` table
      'testsLabSectionId',             // Column in $rows for matching one in labsections table
      ['labSectionId', 'labname'], // Fields to retrieve from the related/users table
      ['labSectionId', 'labname'], // Allowed fields to validate requested fields
      'labSectionInfo',              // Key where related info will be attached
      'LSC-'                   /* prefix for userId here if needed, just incase database userId = 12 instead
                                  of USR-002   */
    );
    return $result;
  }
// =======================================================================================================
// get user information from $rows by testsUserId, enriched with relational data
  public function getUserById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'users',                // Related table name where we are looking for user information
      'userId',               // Column in `users` table
      'testsUserId',          // Column in $rows for matching one in users table
      ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
      ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
      'userInfo',              // Key where related info will be attached
      'USR-'                   /* prefix for userId here if needed, just incase database userId = 12 instead
                                  of USR-002   */
    );
    return $result;
  }

// =======================================================================================================
// Function to get samples information from $rows by testsSampleId, enriched with relational data
  public function getSampleById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'samples',                // Related table name where we are looking for samples information
      'sampleId',               // Column in `samples` table
      'testsSampleId',         // Column in $rows for matching one in samples table
      ['sampleId', 'samplename'], // Fields to retrieve from the related/samples table
      ['sampleId', 'samplename'], // Allowed fields to validate requested fields
      'sampleInfo',              // Key where related info will be attached
      'SAM-'                   /* prefix for sampleId here if needed, just incase database sampleId = 12 instead
                                  of SAM-002   */
    );
    return $result;
  }
// =====================================================================================================
// Function to get units information from $rows by testsUnitId, enriched with relational data
  public function getUnitById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'units',                // Related table name where we are looking for samples information
      'unitId',               // Column in `units` table
      'testsUnitId',           // Column in $rows for matching one in Units table
      ['unitId', 'unitname'], // Fields to retrieve from the related/units table
      ['unitId', 'unitname'], // Allowed fields to validate requested fields
      'unitInfo',              // Key where related info will be attached
      'UNI-'                   /* prefix for unitId here if needed, just incase database unitId = 12 instead
                                  of UNI-002   */
    );
    return $result;
  }
// =====================================================================================================

// Function to get containers information from $rows by testsContainerId, enriched with relational data
  public function getSampleContainerById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'containers',                // Related table name where we are looking for samples information
      'containerId',               // Column in `containers` table
      'testsContainerId',           // Column in $rows for matching one in samples table
      ['containerId', 'containername'], // Fields to retrieve from the related/containers table
      ['containerId', 'containername'], // Allowed fields to validate requested fields
      'containerInfo',              // Key where related info will be attached
      'CON-'                   /* prefix for containerId here if needed, just incase database containerId
                                  = 12 instead of CON-002   */
    );
    return $result;
  }
// =====================================================================================================

}
