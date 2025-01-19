<?php
/**
 * Main Model class
 */
class Model extends Database
{
  public $errors = [];
  protected $table;

// ==========================================================================================
  public function __construct()
  {
    // Automatically set the table name if not defined in the child model
    if (!property_exists($this, 'table'))
    {
        $this->table = strtolower(get_class($this)) . "s"; // Default: Class name + "s" (e.g., Department -> departments)
    }
  }
// ==========================================================================================
  public function where($column, $value, $limit = 10, $offset = 0,$order = 'ASC',$orderColumn = "id")
  {
    $column = addslashes($column);
    $query = "SELECT * FROM $this->table WHERE $column = :value";
    // show($query); die();
    $query .= " ORDER BY $orderColumn $order  LIMIT $limit OFFSET $offset";
    $result = $this->query($query,['value'=>$value]);
    // show($result); die();

    if (is_array($result)) {
      if (property_exists($this, 'afterSelect'))
      {
        foreach ($this->afterSelect as $fucn)
        {
          $result = $this->$fucn($result);
        }

      }
      return $result;
    }
  }
// ==========================================================================================
  // Count rows where the specified column matches the given value
  public function countWhere($column, $value, array $allowedColumns)
  {
      // Check if the column name is valid
      if (!in_array($column, $allowedColumns)) {
          throw new InvalidArgumentException("Invalid column name: {$column}");
      }

      // Build the query and execute it
      $query = "SELECT COUNT(*) AS count FROM {$this->table} WHERE {$column} = :value";
      $result = $this->query($query, ['value' => $value]);

      // Return the count if available or return 0
      return is_array($result) && isset($result[0]->count) ? (int)$result[0]->count : 0;
  }
// ==========================================================================================
  // Generate a unique ID for the specified table
  public function generateUniqueId($idColumn, $prefix, $allowedColumns, $padLength = 3)
  {
    // Query to fetch the last ID from the table
    $query = "SELECT {$idColumn} FROM {$this->table} ORDER BY id DESC LIMIT 1";
    $result = $this->query($query);

    // Retrieve the last ID or assign null
    $lastId = is_array($result) && !empty($result) ? $result[0]->$idColumn : null;

    if (!empty($lastId)) {
      // Extract the numeric part of the last ID
      $prefixLength = strlen($prefix) + 1; // +1 for the hyphen
      $lastNumericId = (int)substr($lastId, $prefixLength);

    do {
        // Increment the numeric part and pad with leading zeros
        $nextId = str_pad(($lastNumericId + 1), $padLength, "0", STR_PAD_LEFT);
        // Create the new ID with prefix
        $newId = $prefix . "-" . $nextId;
        // Check for uniqueness
        $idCount = $this->countWhere($idColumn, $newId, $allowedColumns);

        if ($idCount > 0) {
          // If ID exists, increment the numeric part and retry
          $lastNumericId++;
        }
      } while ($idCount > 0); // Repeat until a unique ID is found

    } else {
      // If no previous ID exists, start with the default
      $newId = $prefix . "-" . str_pad(1, $padLength, "0", STR_PAD_LEFT);
    }
  // Return the generated unique ID
    return $newId;
  }

// find Single record from any mysql listed tables
  public function first($column, $value, $order = 'DESC')
  {
    $column = addslashes($column);
    $query = "SELECT * FROM $this->table WHERE $column = :value";
    // echo $query; die();
    $result = $this->query($query,['value'=>$value]);

    // run function After Selecting a single data from database
    if (is_array($result))
    {
      if (property_exists($this, 'afterSelect'))
      {
        foreach ($this->afterSelect as $fucn)
        {
          $result = $this->$fucn($result);
        }
      }
    }

    if (is_array($result))
    {
      $result = $result[0];
    }
    return $result;
  }
// ==========================================================================================

  public function findAll($limit = 10, $offset = 0,$order = 'DESC',$orderColumn = "id")
  {
    // $query = "SELECT * FROM $this->table ORDER BY $orderColumn $order LIMIT $limit OFFSET $offset";
    $query = "SELECT * FROM $this->table ORDER BY $orderColumn $order";
    $result = $this->query($query);
    // show($result); die();
    if (is_array($result)) {
      if (property_exists($this, 'afterSelect'))
      {
        foreach ($this->afterSelect as $fucn)
        {
          $result = $this->$fucn($result);
        }
      }
      return $result;
    }
  }
// ==========================================================================================
  // insert function
  public function insert($data)
  {
    // remove unwanted columns
    if(property_exists($this, 'allowedColumns'))
    {
      foreach($data as $key => $Allowed)
      {
        if (!in_array($key, $this->allowedColumns))
        {
          unset($data[$key]);
        }

      }
    }
    // run function before inserting
    if(property_exists($this, 'beforeInsert'))
    {

      foreach($this->beforeInsert as $bInsert)
      {
        $data = $this->$bInsert($data);
      }
    }
// show ($data); die();
    $keys    =  array_keys($data);
    $columns =  implode(',', $keys);
    $values  =  implode(',:', $keys);
    $query   =  "INSERT INTO $this->table ($columns) VALUES(:$values)";
    // echo $query; die();
    return $this->query($query,$data);
  }
// ==========================================================================================
  // Update function
  public function update($id,$data)
  {
    // remove unwanted columns
    if(property_exists($this, 'allowedColumns'))
    {
      foreach($data as $key => $Allowed)
      {
        if (!in_array($key, $this->allowedColumns))
        {
          unset($data[$key]);
        }
      }
    }

    $keys = array_keys($data);
    $query = "UPDATE ".$this->table." SET ";
    foreach ($keys as $key)
    {
      $query .= $key ."=:". $key .",";
    }
      $query = trim($query,",");
      $query .= " WHERE id = :id";
      $data['id'] = $id;

    // show ($query); die();

    return $this->query($query,$data);
  }
// ==========================================================================================
  public function delete($id)
  {
    $data['id'] = $id;
    $query = "DELETE FROM $this->table WHERE id = :id";
    return $this->query($query,$data);
  }

/* =========================================================================================== *
 * THE FUNCTIONS BELOW WORKS AS A GROUP OF FUNCTION CONNECTED TOGETHER, ONE LEADS TO THE OTHER *
 * they collect data from any table and any field dynamically using dynamic fieldsList         *
 * attachRelatedData(),processSpecialFields($data),and getRelatedData()                        *
/*============================================================================================ */
protected function attachRelatedData(
    $rows, // The dataset containing the rows to which related data will be attached
    $relationTable, // The name of the related table from which data is being fetched
    $relationIdColumn, // The column in the related table used to match against the $rows data
    $rowsColumn, // The column in the $rows dataset used to match with the related table
    $relationIdPrefix = '', // An optional prefix for IDs (e.g., converting numeric IDs to formatted strings like USR-0001)
    $relationFields = [], // Fields you want to retrieve from the related table
    $allowedFields = [], // Fields explicitly allowed to retrieve (for extra validation of what can be queried)
    $resultKey = 'relatedRow' // The key where the attached related data will be stored in the $rows
) {
  // show($rows);die;

    // Ensure the $rows dataset is valid and is an array
    if (empty($rows) || !is_array($rows)) {
        return $rows; // Return original rows if nothing to process
    }

    // Use all allowed fields if no specific fields are requested
    if (empty($relationFields)) {
        $relationFields = $allowedFields;
    }

    // Validate requested fields to ensure they are part of the allowed fields
    $validFields = !empty($allowedFields)
        ? array_intersect($relationFields, $allowedFields) // Only keep valid fields
        : $relationFields;

    // If no valid fields, return the original rows without changes
    if (empty($validFields)) {
        return $rows;
    }

    // Generate a comma-separated string of valid fields to fetch from the related table
    $fieldsList = implode(',', $validFields);

    // Iterate over each row in the $rows dataset
    foreach ($rows as $key => $row) {
        // Ensure the matching column exists and is not empty for the current row
        if (empty($row->$rowsColumn)) {
            continue; // Skip this row if no matching column value exists
        }

        // Extract and normalize the matching ID from the $rows column
        $relationId = $row->$rowsColumn;
        if (!empty($relationIdPrefix) && is_numeric($relationId)) {
            // If a prefix is provided, normalize the ID with padding and a prefix
            $relationId = $relationIdPrefix . str_pad($relationId, 4, '0', STR_PAD_LEFT);
        }

        // Prepare the query dynamically with the matching column in the related table
        $query = "SELECT {$fieldsList} FROM {$relationTable} WHERE {$relationIdColumn} = :relationId LIMIT 1";

        // Prepare the query parameters with the normalized relation ID
        $params = ['relationId' => $relationId];

        // Execute the query to fetch related data from the relational table
        $relatedData = $this->query($query, $params);

        // If related data is found, process and attach it to the current row
        if (!empty($relatedData) && isset($relatedData[0])) {
            // Optionally process additional fields (such as fullname) if necessary
            // call processSpecialFields() function is just below.
            $this->processSpecialFields($relatedData[0]);

            // Attach the related data to the current row under the specified result key
            $rows[$key]->$resultKey = $relatedData[0];
        }
    }

    // Return the updated $rows dataset, now enriched with related data
    return $rows;
}
// ========================================================================================== *
/**
 * Process any special field combinations or transformations
 * For example, add a `fullname` field to the related data by combining `firstname` and `lastname`
 */
protected function processSpecialFields($data) {
    if (isset($data->firstname) && isset($data->lastname)) {
        // Concatenate first and last name to create a full name
        $data->fullname = esc($data->firstname . " " . $data->lastname);
    }
} // End to Process any special field combinations or transformations function

// ========================================================================================== *
/**
 * Helper function to get related data dynamically.
 * This wraps the `attachRelatedData` function for easier reuse.
 *
 * @param array $rows The dataset to enrich with related data
 * @param string $relationTable The name of the relational table
 * @param string $relationIdColumn The column in relationTable used for matching
 * @param string $rowsColumn The column in rows used for matching
 * @param array $relationFields The fields to retrieve from the relationTable
 * @param array $allowedFields Fields explicitly allowed to fetch
 * @param string $resultKey Key name where related data is attached in rows
 * @param string $relationIdPrefix Optional prefix for relational IDs
 *
 * @return array Modified $rows with related data attached
 */
public function getRelatedData(
    $rows,
    $relationTable,
    $relationIdColumn,
    $rowsColumn,
    $relationFields = [],
    $allowedFields = [],
    $resultKey = 'relatedRow',
    $relationIdPrefix = ''
) {
    // Call the `attachRelatedData()` function above to handle the actual logic
    return $this->attachRelatedData(
        $rows,
        $relationTable,
        $relationIdColumn,
        $rowsColumn,
        $relationIdPrefix,
        $relationFields,
        $allowedFields,
        $resultKey
    );
}
/* ========================================================================================== *
* THE END OF CONNECTED FUNCTION TO FETCH DATA USING DYNAMIC FIELDS                            *
* =========================================================================================== */

}
