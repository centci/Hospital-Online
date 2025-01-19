<?php
/**
 * ExtraTest Class Model
 */
class ExtraTest extends Model
{
  protected $table = "extratests";
  protected $allowedColumns = [
    'xtraTestName',
    'xtraRefRanges',
    'xtraTestCode',
    'xtraUnitid',
    'xtraUserId',
    'xtraTestDate',
  ];

  protected $afterSelect = [
    'getUserById',
    'getUnitById',
  ];

// =======================================================================================================
// get user information from $rows by xtraUserId, enriched with relational data
  public function getUserById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'users',                // Related table name where we are looking for user information
      'userId',               // Column in `users` table
      'xtraUserId',          // Column in $rows for matching one in users table
      ['userId', 'firstname', 'lastname'], // Fields to retrieve from the related/users table
      ['userId', 'firstname', 'lastname'], // Allowed fields to validate requested fields
      'userInfo',              // Key where related info will be attached
      'USR-'                   /* prefix for userId here if needed, just incase database xtraUserId = 12 instead
                                  of USR-002   */
    );
    return $result;
  }

// =======================================================================================================
// Function to get units information from $rows by xtraUnitid, enriched with relational data
  public function getUnitById($rows) {
    $result = $this->getRelatedData(
      $rows,                  // The existing dataset
      'units',                // Related table name where we are looking for samples information
      'unitId',               // Column in `units` table
      'xtraUnitid',           // Column in $rows for matching one in units table
      ['unitId', 'unitname'], // Fields to retrieve from the related/units table
      ['unitId', 'unitname'], // Allowed fields to validate requested fields
      'unitInfo',              // Key where related info will be attached
      'UNI-'                   /* prefix for xtraUnitid here if needed, just incase database xtraUnitid = 12 instead
                                  of UNI-002   */
    );
    return $result;
  }
// =====================================================================================================

}
