<?php
/**
 * Database Connection
 */
class Database
{
  private function connect()
  {
    $string = DBDRIVER . ":host=".DBHOST.";dbname=".DBNAME;
    if (!$con = new PDO($string, DBUSER, DBPASS))
    {
      die("could not connect to database");
    }
    return $con;
  }

  public function query($query, $data =[], $datatype ="object")
  {
    $con = $this->connect();

    $stm = $con->prepare($query);
    if ($stm)
    {
      $check = $stm->execute($data);
      if ($check)
      {
        if ($datatype == "object")
        {
          $data = $stm->fetchAll(PDO::FETCH_OBJ);
        }else
        {
          $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        if (is_array($data) && count($data) > 0)
        {
          // afterSelect
          if (property_exists($this, 'afterSelect'))
          {
            foreach ($this->afterSelect as $fucn)
            {
              $data = $this->$fucn($data);
            }
          }
          return $data;
        }
      }
    }
    return false;
  }
}
