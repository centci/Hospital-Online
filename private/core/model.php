<?php
/**
 * Main Model class
 */
class Model extends Database
{
  public $errors = [];

  public function __construct()
  {
    if(!property_exists($this, 'table'))
    {
      $this->table = strtolower(get_class($this))."s";

    }
  }

  public function where($column, $value, $limit = 10, $offset = 0,$order = 'ASC',$orderColumn = "id")
  {
    $column = addslashes($column);
    $query = "SELECT * FROM $this->table WHERE $column = :value";
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

  public function findAll($limit = 10, $offset = 0,$order = 'DESC',$orderColumn = "id")
  {
    // $query = "SELECT * FROM $this->table ORDER BY $orderColumn $order LIMIT $limit OFFSET $offset";
    $query = "SELECT * FROM $this->table ORDER BY $orderColumn $order";
    $result = $this->query($query);
    // echo $result; die();
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

  // insert function
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

  public function delete($id)
  {
    $data['id'] = $id;
    $query = "DELETE FROM $this->table WHERE id = :id";
    return $this->query($query,$data);
  }
}
