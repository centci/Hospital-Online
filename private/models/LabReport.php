<?php
/**
 * LabReport Class Model
 */
class LabReport extends Model
{
  protected $table = 'labReports';

  protected $allowedColumns = [
    'labReportId',
    'testResult',
    'reportLabReqSampleId',
    'reportTestCode',
    'reportExtraSubTestCode',
    'reportUserId',
    'reportDate'
  ];
  // form validation before inserting data
  public function validate($DATA,$id = null)
  {
    // show($DATA);die;
    $this->errors = [];
    if (isset($DATA['testResult']))
    {
      // Validate Tests Name
      if (empty($DATA['testResult']))
      {
        $this->errors['testResult'] = "Test Result Required!";
      }
    }
    // ===================TESTS EXTRA VALIDATION======================
    // Define the base keys to be validated
    $baseKeys = ['extratestResults']; //you can add as many as you want depending on the field you want to check error from your form
    $suffixes = range(0, 60); // Using range to create an array of suffixes from 0 to 60

      // Define an associative array to store display names for the fields and errors messages
      $fieldDisplayNames = [
        'extratestResults' => 'Test Result',
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
      // show($this->errors);die;
    // ==================TESTS EXTRA VALIDATION END====================
    // If there are no errors, return true; otherwise, return false
    if (count($this->errors) == 0)
    {
      return true;
    }
    return false;
    // the end
  }

}
